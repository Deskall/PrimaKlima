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

class MemberProfilePageController extends PageController{

	private static $allowed_actions = ['upload', 'UploadForm', 'UpdateExistingDocument','DeleteObject', 'saveFolder', 'EditFile', 'DeleteFile', 'acceptContract','SaveTimeSheet','DeleteTimeSheet','ProfilForm', 'AccountForm','JobOfferForm','EditJobOffer','DeleteJobOffer'];

	private static $url_handlers = [
		'delete-object/$ID/$OBJECT' => 'DeleteObject',
		'edit-file/$ID/$NEWNAME' => 'EditFile',
		'delete-file/$ID' => 'DeleteFile',
		'bestaetigen/auftrag/$ID/$CookID' => 'acceptContract',
		'wochen-zeiten' => 'SaveTimeSheet',
		'wochen-zeiten-loeschen' => 'DeleteTimeSheet',
		'inserat-bearbeiten/$ID' => 'EditJobOffer',
		'inserat-loeschen/$ID' => 'DeleteJobOffer',
	];

	public function activeTab(){
		$activeTab = $this->getRequest()->getSession()->get('active_tab');
		$this->getRequest()->getSession()->clear('active_tab');
		return $activeTab;
	}

	public function init(){
		parent::init();

		Requirements::javascript('silverstripe/admin:client/dist/js/i18n.js');
		Requirements::add_i18n_javascript('deskall-users/javascript/lang');
		Requirements::javascript('silverstripe/admin: client/dist/js/vendor.js');
		Requirements::javascript('silverstripe/admin: client/dist/js/bundle.js');
		Requirements::javascript('deskall-job-portal/javascript/jobportal.js');
		if (!$this->getRequest()->getVar('CMSPreview')){
			if (!Security::getCurrentUser()){
				return Security::permissionFailure($this, _t(
					'MemberProfiles.NeedToLogin',
					'Sie müssen sich anmelden, um auf diese Seite zugreifen zu können'
				));
			}
			if(!Security::getCurrentUser()->inGroup($this->Group()->Code)){
				return Security::permissionFailure($this, _t(
					'MemberProfiles.AccessDenied',
					'Sie dürfen diesen Bereich nicht betreten.'
				));
			}
			if(Security::getCurrentUser()->isRefused){
				return Security::permissionFailure($this, _t(
					'MemberProfiles.AccessDenied',
					'Sie dürfen diesen Bereich nicht betreten.'
				));
			}
		}
		
		
	}

	
	public function ProfilForm(){

		$actions = new FieldList(FormAction::create('saveProfil', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$JobGiver = ($JobGiver) ? $JobGiver : new JobGiver();
		$status = $JobGiver->Status;
		// if (!$status){
		// 	$actions->push(FormAction::create('requireApproval', _t('MemberProfiles.REQUIREAPPROVAL', 'Genehmigung erfordern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="fa fa-check uk-margin-small-right"></i>'. _t('MemberProfiles.REQUIREAPPROVAL', 'Genehmigung erfordern')));
		// }
		// if (Security::getCurrentUser()->Status == "waitForApproval"){
		// 	$actions->push(FormAction::create('requireApproval', _t('MemberProfiles.APPROVALCHECK', 'Genehmigung in Bearbeitung'))->setDisabled(true)->setButtonContent('<i class="fa fa-check uk-margin-small-right"></i>Genehmigung in Bearbeitung')->addExtraClass('uk-button'));
		// }

		
		
		$form = new Form(
			$this,
			'ProfilForm',
			$JobGiver->getProfileFields(),
			$actions,
			$JobGiver->getRequiredProfileFields()
		);
		
		$form->setTemplate('Forms/ProfilForm');
		$form->addExtraClass('uk-form-horizontal form-std company-form');
		$form->loadDataFrom($JobGiver);

		return $form;
	}

	public function saveProfil($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$form->saveInto($member);
		$form->saveInto($JobGiver);
	
		try {
			$member->write();
			$JobGiver->write();
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
			return $this->redirectBack();
		}
		$form->sessionMessage(
			_t('MemberProfiles.PROFILEUPDATED', 'Ihre Profil wurde aktualisiert.'),
			'good'
		);
		$this->getRequest()->getSession()->set('active_tab','profil');
		
		return $this->redirectBack();
	}

	public function AccountForm(){

		$actions = new FieldList(FormAction::create('saveAccount', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$JobGiver = ($JobGiver) ? $JobGiver : new JobGiver();



		
		
		$form = new Form(
			$this,
			'AccountForm',
			$JobGiver->getAccountFields(),
			$actions,
			$JobGiver->getRequiredAccountFields()
		);
		
		// $form->setTemplate('Forms/ProfilForm');
		$form->addExtraClass('uk-form-horizontal form-std');
		$form->loadDataFrom($JobGiver);

		return $form;
	}

	public function saveAccount($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$form->saveInto($member);
		$form->saveInto($JobGiver);
	
		try {
			$member->write();
			$JobGiver->write();
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
			return $this->redirectBack();
		}
		$form->sessionMessage(
			_t('MemberProfiles.PROFILEUPDATED', 'Ihre Profil wurde aktualisiert.'),
			'good'
		);
		$this->getRequest()->getSession()->set('active_tab','account');
		
		return $this->redirectBack();
	}

	public function JobOfferForm(){

		$actions = new FieldList(FormAction::create('saveOffer', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$status = $JobGiver->Status;
		// if (!$status){
		// 	$actions->push(FormAction::create('requireApproval', _t('MemberProfiles.REQUIREAPPROVAL', 'Genehmigung erfordern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="fa fa-check uk-margin-small-right"></i>'. _t('MemberProfiles.REQUIREAPPROVAL', 'Genehmigung erfordern')));
		// }
		// if (Security::getCurrentUser()->Status == "waitForApproval"){
		// 	$actions->push(FormAction::create('requireApproval', _t('MemberProfiles.APPROVALCHECK', 'Genehmigung in Bearbeitung'))->setDisabled(true)->setButtonContent('<i class="fa fa-check uk-margin-small-right"></i>Genehmigung in Bearbeitung')->addExtraClass('uk-button'));
		// }

		$offer = new Mission();
		
		$form = new Form(
			$this,
			'JobOfferForm',
			$offer->getFormFields(),
			$actions,
			$offer->getRequiredFields()
		);
		
		$form->setTemplate('Forms/OfferForm');
		$form->addExtraClass('uk-form-horizontal form-std');
		if ($this->getRequest()->getSession()->get('offer_id')){
			$offer = Mission::get()->byId($this->getRequest()->getSession()->get('offer_id'));
			$form->loadDataFrom($offer);
		}
		
		return $form;
	}

	public function EditJobOffer(HTTPRequest $request){
		$id = $request->param('OfferId');
		if ($id){
			$this->getRequest()->getSession()->set('offer_id',$id);
		}
		return ['Title' => 'Stellenangebot bearbeiten'];
	}

	public function DeleteJobOffer(HTTPRequest $request){
		$id = $request->param('OfferId');
		if ($id){
			$offer = Mission::get()->byId($id);
			if ($offer){
				$offer->delete();
			}
		}
		return $this->redirectBack();
	}

	public function saveOffer($data, Form $form)
	{
		$offer = new Mission();
		$form->saveInto($offer);
		try {
			$offer->write();
			
			//parameters
			$config = $offer->getJobConfig();
			foreach ($config->Parameters() as $p) {
				if(isset($data[$p->Title])){
					$value = JobParameterValue::get()->byId($data[$p->Title]);
					if ($value){
						$assignedP = new AssignedJobParameter();
						$assignedP->Title = $p->Title;
						$assignedP->Value = $value->Title;
						$assignedP->MissionID = $offer->ID;
						$assignedP->write();
					}
				}
			}

		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
			return $this->redirectBack();
		}
		$form->sessionMessage(
			_t('MemberProfiles.PROFILEUPDATED', 'Ihre Inserate wurde gespeichert.'),
			'good'
		);
		$this->getRequest()->getSession()->set('active_tab','offers');
		
		return $this->redirectBack();
	}

	

	public function sendApprovalEmail($member){
		$page = RegisterPage::get()->first();
	        	$emailAdmin = $page->ApprovalEmailReceiver;
	        	if (!$emailAdmin){
	        		$config = SiteConfig::current_site_config();
	        		$emailAdmin = $config->Email;
	        	}
	        	
	        	$body = $page->ApprovalEmailBody;
	        	$body .= '<p><strong>'._t('Member.UserType','Koch').' :</strong><br>'.$member->getTitle().'</p>';
	        	$body .= '<p><a href="'.Director::absoluteBaseUrl().'admin/'.Config::inst()->get('UserAdmin','url_segment').'">'._t('Member.CheckProfile','Profil prüfen').'</a></p>';
	        	$email = new MemberEmail($this->data(),$member,$page->ApprovalEmailSender, $emailAdmin,$page->ApprovalEmailSubject,  $body);
	        	
	        	$email->send(); 
	}


	public function upload(HTTPRequest $request){
		
		$tmpFiles = $request->postVar('files');
		
		$tmpFile = [];
		foreach($tmpFiles as $key => $array){
			$tmpFile[$key] = $array[0];
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