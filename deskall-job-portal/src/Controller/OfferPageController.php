<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Session;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Security\Group;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Upload;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\Storage\AssetStore;
use SilverStripe\ORM\DB;
use SilverStripe\View\ArrayData;
use SilverStripe\Security\DefaultAdminService;
use SilverStripe\Admin\ModalController;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\ORM\ArrayList;


class OfferPageController extends PageController{

	private static $allowed_actions = ['OfferForm','confirmMission','candidate','JobOffer','ApplicationForm','upload','Candidature', 'DeclineCandidature'];

	private static $url_handlers = [
		'details/$ID' => 'JobOffer',
		'bestaetigung/$ID' => 'confirmMission',
		'bewerben/$ID' => 'candidate',
		'bewerbung/$ID' => 'Candidature',
		'bewerbung-ablehnen' => 'DeclineCandidature'
	];

	public function init(){
		parent::init();
		Requirements::javascript('deskall-job-portal/javascript/jobsearch.js');
	}

	public function Modals() 
    {
        return ModalController::create($this, "Modals");
    }

    public function JobOffer(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$offer = Mission::get()->byId($id);
			if ($offer){
				return ['Title' => 'Stellenangebot - '.$offer->Title,'Offer' => $offer];
			} 
		}
		return $this->httpError(404);
    }

 //    public function activeOffers(){
	// 	$offers =  new PaginatedList(Mission::get()->filter('isActive',1),$this->getRequest());
	// 	$offers->setPageLength(4);
	// 	return $offers;
	// }

	public function index(HTTPRequest $request){
		$filters = $request->getVar('filters');
		if ($request->getVar('position')){
			$filters[] = ['dataType' => 'parameter','filter' => 'Position','value' => $request->getVar('position') ];
		}
		if ($request->getVar('ort')){
			$filters[] = ['dataType' => 'data','filter' => 'City','value' => $request->getVar('ort') ];
		}
		$arrayFilters = [];
		$offers = Mission::get()->filter('isActive',1);
		if (!empty($filters)){
			$filteredIDS = [];
			foreach($filters as $key => $filter){
				$arrayFilters[] = new ArrayData(['Title' => $filter['filter'], 'Value' => $filter['value']]);
				if ($filter['dataType'] == "parameter"){
					$ids = AssignedJobParameter::get()->filter(['Title' => $filter['filter'], 'Value' => $filter['value']])->column('MissionID');
				}
				if ($filter['dataType'] == "data"){
					if ($filter['filter'] == "Country"){
						$ids = Mission::get()->filter($filter['filter'], array_search($filter['value'],i18n::getData()->getCountries()))->column('ID');
					}
					else if ($filter['filter'] == "Date"){
						$start = new \DateTime();
						$end = new \DateTime();
						if ($filter['value'] == _t('Mission.PublishedPeriod1','< 3 Tage')){
							$end->modify('- 3 days');
							$ids = Mission::get()->filter('PublishedDate:GreaterThan', $end->format('Y-m-d'))->column('ID');
						}
						if ($filter['value'] == _t('Mission.PublishedPeriod2','3 - 7 Tage')){
							$start->modify('-3 days');
							$end->modify('- 7 days');
							$ids = Mission::get()->filter(['PublishedDate:LessThanOrEqual' => $start->format('Y-m-d'),'PublishedDate:GreaterThan' => $end->format('Y-m-d')])->column('ID');
						}
						if ($filter['value'] == _t('Mission.PublishedPeriod3','7 - 14 Tage')){
							$start->modify('-7 days');
							$end->modify('- 14 days');
							$ids = Mission::get()->filter(['PublishedDate:LessThanOrEqual' => $start->format('Y-m-d'),'PublishedDate:GreaterThan' => $end->format('Y-m-d')])->column('ID');
						}
						if ($filter['value'] == _t('Mission.PublishedPeriod4','> 14 Tage')){
							$end->modify('- 14 days');
							$ids = Mission::get()->filter('PublishedDate:LessThan', $end->format('Y-m-d'))->column('ID');
						}
					}
					else{
						$ids = Mission::get()->filter($filter['filter'], $filter['value'])->column('ID');
					}
					
				}
				if (!empty($filteredIDS)){
					$filteredIDS = array_intersect($ids,$filteredIDS);
				}
				else {
					$filteredIDS = $ids;
				}
				
			}
			$offers = (!empty($filteredIDS)) ? $offers->filter('ID',$filteredIDS) : null;
		}
		$offers = ($offers) ? new PaginatedList($offers->sort('PublishedDate','DESC'),$this->getRequest()) : null;
		if ($offers){
			$offers->setPageLength(4);
		}
		if ($request->isAjax()){
			return $this->customise(new ArrayData([
			        'activeOffers' => $offers
			]))->renderWith('Includes/FilteredOffers');
		}
		return [
			     'activeOffers' => $offers,
			     'filters' => new ArrayList($arrayFilters)
			];
	}

	public function candidate(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$mission = Mission::get()->byId($id);
			if ($mission){
				$this->getRequest()->getSession()->set('mission_id',$id);
				return ['Title' => 'Bewerben', 'Offer' => $mission];
			}
		}
		return $this->httpError(404);
	}

	public function Candidature(HTTPRequest $request){
		if (!Security::getCurrentUser()){
			return Security::permissionFailure($this, null);
		}
		$id = $request->param('ID');
		if ($id){
			$Candidature = Candidature::get()->byId($id);
			if ($Candidature){
				if ($Candidature->canView()){
					return ['Title' => 'Bewerbung für die Stellenangebot '.$Candidature->Mission()->Nummer, 'Candidature' => $Candidature];
				}
			}
		}
		return $this->httpError(404);
	}

	public function DeclineCandidature(HTTPRequest $request){
		if ($request->isPost()){
			$id = $request->postVar('CandidatureID');
			$Candidature = Candidature::get()->byId($id);
			if ($Candidature){
				$Candidature->Status = 'declined';
				$Candidature->write();
				$Candidature->sendDeclineEmail($request->postVar('message'));
				return $this->redirect(MemberProfilePage::get()->first()->Link());
			}
			return $this->httpError(404);
		}
		
		return $this->httpError(400);
	}

	public function ApplicationForm(){

		$actions = new FieldList(FormAction::create('saveApplication', _t('APPLICATION.SEND', 'Bewerben'))->addExtraClass('uk-button button-PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-ios-paperplane uk-margin-small-right"></i>'._t('APPLICATION.SEND', 'Bewerben')));
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		
		$form = new Form(
			$this,
			'ApplicationForm',
			FieldList::create(
				HiddenField::create('MissionID')->setValue($this->getRequest()->getSession()->get('mission_id')),
				HiddenField::create('CandidatID')->setValue($candidat->ID),
				HeaderField::create('FormTitle', 'Jetzt für Stelle bewerben'),
				LiteralField::create('FormCaption', '<p>Füllen Sie unten stehendes Formular aus, um sich ganz schnell und einfach für ihre Traumstelle zu bewerben.</p>'),
				TextareaField::create('Content', _t('APPLICATION.Content', 'Bewerbungtext')),
				CheckboxField::create('UseData',_t('APPLICATION.Content','Bewerben Sie sich mit Ihrem Profil Lebenslauf'))->setValue(true),
				UploadField::create('CV',_t('APPLICATION.CVLabel2', 'Oder laden Sie hier Ihr CV'))->setFolderName('Uploads/tmp'),
				CheckboxField::create('Acceptance',DBHTMLText::create()->setValue(_t('APPLICATION.Acceptance','<div class="dk-text-content">Wenn Sie dieses Kontrollkästchen aktivieren und auf "Bewerben" klicken, stimmen Sie unseren <a href="services/agb" target="_blank">Nutzungsbedingungen</a> zu und ermächtigen uns, Ihnen ähnliche Ankündigungen per E-Mail zu senden. Sie können diese Entscheidung jederzeit widerrufen, indem Sie sich abmelden oder das in unseren Nutzungsbedingungen beschriebene Verfahren befolgen.</div>')))
			),
			$actions,
			new RequiredFields(['Content','Acceptance'])
		);
		$form->setTemplate('Forms/ApplicationForm');
		$form->addExtraClass('form-std');

		return $form;
	}

	public function saveApplication($data, Form $form)
	{
		
		$config = JobPortalConfig::get()->first();
		$member = Security::getCurrentUser();
		if ($member){
			$candidat = Candidat::get()->filter('MemberID',$member->ID)->first();
			
			try {
				$cd = new Candidature();
				$form->saveInto($cd);
				$cd->Status = "created";
				$cd->write();
				$cd->createPDF();
				return ['Title' => 'Bewerbung gesendet', 'Content' =>  DBHTMLText::create()->setValue($config->parseString($config->CandidatureSentText))];
			} catch (ValidationException $e) {
				$validationMessages = '';
				foreach($e->getResult()->getMessages() as $error){
					$validationMessages .= $error['message']."\n";
				}
				$form->sessionMessage($validationMessages, 'bad');
				return $this->redirectBack();
			}
		}
		return $this->redirectBack();
	}

	// public function OfferForm(){
	// 	Requirements::javascript('silverstripe/admin: client/dist/js/vendor.js');
	// 	Requirements::javascript('silverstripe/admin: client/dist/js/bundle.js');
		
	// 	$mission = Mission::create();
	// 	$customer = Customer::create();
		
	// 	$fields = $mission->getFrontEndFields();
	// 	$fields->removeByName('Status');
	// 	$fields->removeByName('Title');
	// 	$fields->removeByName('CustomerID');
	// 	$fields->removeByName('JobID');
	// 	$fields->removeByName('CookID');
	// 	$fields->removeByName('Position');
	// 	$fields->removeByName('Price');
	// 	$fields->removeByName('Country');
	// 	$fields->removeByName('AdminComments');
	// 	$fields->removeByName('Price');
	// 	$fields->removeByName('Anfahrt');
	// 	$fields->removeByName('CostAndHousing');
	// 	$fields->removeByName('Period');
	// 	$fields->fieldByName('Start')->setAttribute('class','flatpickr')->setAttribute('type','text');
	// 	$fields->fieldByName('End')->setAttribute('class','flatpickr')->setAttribute('type','text');
	// 	$fields->removeByName('Access');
	// 	$fields->fieldByName('Others')->setRows(3);
	// 	$sources = CookJob::get()->map('ID','FullTitle');
	// 	$sources->push('other',_t('CookJob.Other','Andere'));
	// 	$fields->insertBefore('Start',DropdownField::create('Position','Position',$sources)->setAttribute('class','uk-select')->setEmptyString('Position wählen'));
		
	// 	$fields->insertAfter('Position',TextField::create('OtherJob','Position angeben')->displayIf('Position')->isEqualTo('other')->end());
	// 	$fields->push(DropdownField::create('Gender',$customer->fieldLabels(false)['Gender'],['Herr' => 'Herr','Frau' => 'Frau'])->setEmptyString('Bitte wählen')->setAttribute('class','uk-select'));
	// 	$fields->push(TextField::create('FirstName','Vorname'));
	// 	$fields->push(TextField::create('Surname','Name')->addExtraClass('second'));

	// 	$fields->replaceField('Email',EmailField::create('Email',_t('OfferForm.EmailLabel','E-Mail-Adresse')));


	// 	$actions = new FieldList(FormAction::create('save', _t('Offer.SAVE', 'Auftrag erstellen'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="fa fa-check uk-margin-small-right"></i>'. _t('Offer.SAVE', 'absenden')));
		
	// 	$required = RequiredFields::create(['Gender','FirstName','Surname','Position','Email','PostalCode','City','Phone','Place','Start','End','JobID']);


	// 	//Job Options
	// 	$jobs = CookJob::get();
	// 	$options = [];
	// 	foreach ($jobs as $job) {
	// 		if ($job->Options()->exists()){
	// 			$options[] = CheckboxSetField::create('Options-'.$job->ID,'Optionen',$job->Options()->map('ID','Title')->toArray())->displayIf('Position')->isEqualTo($job->ID)->end();
	// 		}
	// 	}
	// 	$fields->insertAfter('Position',CompositeField::create($options)->setName('Options'));

	// 	$form = new Form(
	// 		$this,
	// 		'OfferForm',
	// 		$fields,
	// 		$actions,
	// 		$required
	// 	);
		
	// 	$form->setTemplate('Forms/OfferForm');
	// 	$form->addExtraClass('uk-form-horizontal form-std');
		

	// 	return $form;
	// }

	// public function save($data, Form $form)
	// {
		

	// 	//$member = Security::getCurrentUser();
	// 	$mission = new Mission();
	// 	$form->saveInto($mission);
	// 	// if($member){
	// 	// 	$mission->CustomerID = $member->ID;
	// 	// }
	// 	// else {
	// 		//check for existing customer
	// 		$member = Member::get()->filter('Email' , $data['Email'])->first();
	// 		if (!$member){
	// 			$member = new Member();
	// 			$form->saveInto($member);
	// 			$member->write();
				
	// 		}
	// 		$member->addToGroupByCode('kunden');
	// 		$customer = ($member) ? Customer::get()->filter('memberID' , $member->ID)->first() : null;
	// 		if (!$customer){
	// 			$customer = Customer::create();
	// 			$form->saveInto($customer);
	// 			$customer->MemberID = $member->ID;
	// 			$customer->write();
	// 		}
	// 	// }
	// 	if (isset($data['Start'])){
	// 		$start = new \DateTime($data['Start']);
	// 		$mission->Start = $start->format('Y-m-d');
	// 	}
	// 	if (isset($data['End'])){
	// 		$end = new \DateTime($data['End']);
	// 		$mission->End = $end->format('Y-m-d');
	// 	} 
	// 	if ($data['Position'] == "other"){
	// 		$job = CookJob::create();
	// 		$job->Title = $data['OtherJob'];
	// 		$job->write();
	// 		$mission->Position = $data['OtherJob'];
	// 	}
	// 	else{
	// 		$job = CookJob::get()->byID($data['Position']);
	// 	}

	// 	//Options
	// 	$options = array_filter($data, function($key) {
	// 	    return strpos($key, 'Options-') === 0;
	// 	},ARRAY_FILTER_USE_KEY);

	// 	foreach($options as $key => $value){
	// 		$obj = CookJobOption::get()->byID($value);
	// 		if ($obj){
	// 			$mission->Options()->add($obj);
	// 		}
	// 	}

	// 	$mission->JobID = $job->ID;
	// 	$mission->CustomerID = $customer->ID;
	// 	$mission->Status = "created";
	// 	$config = $mission->getCookConfig();
	// 	try {
	// 		$mission->write();
	// 		if (!$mission->Price){
	// 		    $mission->Price = $mission->calculatePrice();
	// 		    $mission->CustomerPrice = $mission->calculateCustomerPrice();
	// 		    if ($mission->Price && $mission->CustomerPrice){
	// 		        $mission->createOffer();
			       
	// 		        if ($config->AutoOffer){
	// 		        	$mission->sendOfferMail();
	// 		        	$mission->Status = "sentToCustomer";
	// 		        }
	// 		        else{
	// 		        	$mission->sendAdminMail();
	// 		        }
	// 		        $mission->write();
	// 		    }
	// 		    else{
	// 		        $mission->sendAdminMail();

	// 		    }
	// 		}      
	// 	} catch (ValidationException $e) {
	// 		$validationMessages = '';
	// 		foreach($e->getResult()->getMessages() as $error){
	// 			$validationMessages .= $error['message']."\n";
	// 		}
	// 		$form->sessionMessage($validationMessages, 'bad');
	// 		return $this->redirectBack();
	// 	}
	// 	if ($config->AutoOffer){
	// 		return $this->redirect($this->RedirectWithOffer()->Link());
	// 	}
	// 	return $this->redirect($this->RedirectWithoutOffer()->Link());
	// }

	public function confirmMission(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$key = $request->getVar('key');
			if ($key){
				$mission = Mission::get()->byId($id);
				$config = CookConfig::get()->first();
				if ($mission && $mission->OfferKey == $key){
					if ($mission->Status == "sentToCustomer"){
						$mission->confirmedByCustomer();
						return ['Title' => 'Auftrag bestätigt', 'Content' => $config->OfferConfirmedText];
					}
					return ['Title' => 'Auftrag bestätigt', 'Content' => $config->OfferAlreadyConfirmedText];
				}
				
			}
		}
		return $this->httpError(404);
	}


	public function upload(HTTPRequest $request){
		
		$tmpFiles = $request->postVar('files');

		if (is_array($tmpFiles['name'])){
			$tmpFile = [];
			foreach($tmpFiles as $key => $array){
				$tmpFile[$key] = $array[0];
			}
		}
		else{
			$tmpFile = $tmpFiles;
		}
		
		$tmpFolder = "Uploads/tmp";
		Folder::find_or_make($tmpFolder);
		
		if(in_array($tmpFile['type'], ['image/png','image/jpg','image/jpeg','image/svg+xml','image/gif'])){
			$file = Image::create();
		}
		else{
			$file = File::create();
		}
		
		$upload = Upload::create();

		$upload->loadIntoFile($tmpFile, $file, $tmpFolder);


                    // Upload check
		if ($upload->isError()) {
			$result = [
                'message' => [
                    'type' => 'error',
                    'value' => 'erreur',
                ]
            ];
            
            return (new HTTPResponse(json_encode($result), 400))
                ->addHeader('Content-Type', 'application/json');
		} else {
			$file->publishSingle();
                    $result = [
                        AssetAdmin::singleton()->getObjectFromData($file)
                    ];

                    // Don't discard pre-generated client side canvas thumbnail
                    if ($result[0]['category'] === 'image') {
                        unset($result[0]['thumbnail']);
                    }
                  
                    return (new HTTPResponse(json_encode($result)))
                        ->addHeader('Content-Type', 'application/json');
		}
	}
	



}