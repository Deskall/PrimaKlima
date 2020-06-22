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
use SilverStripe\Forms\DropdownField;
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

	private static $allowed_actions = ['upload', 'ProfilForm', 'AccountForm','JobOfferForm','EditJobOffer','DeleteJobOffer','PublishJobOffer','UnpublishJobOffer', 'CandidatProfilForm','CompetencesForm','CandidatAccountForm', 'DeleteCandidature'];

	private static $url_handlers = [
		'inserat-bearbeiten/$ID' => 'EditJobOffer',
		'inserat-loeschen/$ID' => 'DeleteJobOffer',
		'inserat-veroeffentlichen/$ID' => 'PublishJobOffer',
		'inserat-parkieren/$ID' => 'UnpublishJobOffer',
		'bewerbung-loeschen/$ID' => 'DeleteCandidature',
	];

	public function activeTab(){
		$activeTab = $this->getRequest()->getSession()->get('active_tab');
		$this->getRequest()->getSession()->clear('active_tab');
		return $activeTab;
	}

	public function AccountMessage(){
		if ($message = $this->getRequest()->getSession()->get('account_message')){
			$this->getRequest()->getSession()->clear('account_message');
			return $message;
		}
		return null;
	}

	public function init(){
		parent::init();

		Requirements::javascript('silverstripe/admin:client/dist/js/i18n.js');
		Requirements::add_i18n_javascript('deskall-job-portal/javascript/lang');
		Requirements::javascript('silverstripe/admin: client/dist/js/vendor.js');
		Requirements::javascript('silverstripe/admin: client/dist/js/bundle.js');
		Requirements::javascript('deskall-job-portal/javascript/jobportal.js');

		
		
	}

	public function MatchingToolPage(){
	   return MatchingToolPage::get()->first();
	}

	public function index(){
		$this->getRequest()->getSession()->clear('offer_id');
		return [];
	}


//Arbeitgeber
	
	public function ProfilForm(){

		$actions = new FieldList(FormAction::create('saveProfil', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$JobGiver = ($JobGiver) ? $JobGiver : new JobGiver();
		$status = $JobGiver->Status;
		
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
			//Update all Offers
			if ($JobGiver->Missions()->exists()){
				foreach ($JobGiver->Missions() as $m) {
					$m->write();
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
			_t('MemberProfiles.PROFILEUPDATED', 'Ihr Konto wurde aktualisiert.'),
			'good'
		);
		$this->getRequest()->getSession()->set('active_tab','account');
		
		return $this->redirectBack();
	}

	public function JobOfferForm(){

		$actions = new FieldList(FormAction::create('saveOffer', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$status = $JobGiver->Status;

		if ($this->getRequest()->getSession()->get('offer_id')){
			$offer = Mission::get()->byId($this->getRequest()->getSession()->get('offer_id'));
		}
		$offer = (isset($offer)) ? $offer : new Mission();
		
		$form = new Form(
			$this,
			'JobOfferForm',
			$offer->getFormFields(),
			$actions,
			$offer->getRequiredFields()
		);
		
		$form->setTemplate('Forms/MissionForm');
		$form->addExtraClass('uk-form-horizontal form-std');
		if ($this->getRequest()->getSession()->get('offer_id')){
			$form->loadDataFrom($offer);
		}
		
		return $form;
	}

	public function EditJobOffer(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$this->getRequest()->getSession()->set('offer_id',$id);
		}
		return ['Title' => 'Stellenangebot bearbeiten'];
	}

	public function DeleteJobOffer(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$offer = Mission::get()->byId($id);
			if ($offer){
				$offer->delete();
			}
		}
		return $this->redirectBack();
	}

	public function PublishJobOffer(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$offer = Mission::get()->byId($id);
			if ($offer){
				$offer->publish();
				$this->getRequest()->getSession()->set('active_tab','offers');
				$this->getRequest()->getSession()->set('account_message',_t('MemberProfiles.OfferPublished', 'Ihr Angebot wurde veröffentlicht.'));
			}
		}
		return $this->redirectBack();
	}

	public function UnpublishJobOffer(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$offer = Mission::get()->byId($id);
			if ($offer){
				$offer->unpublish();
				$this->getRequest()->getSession()->set('active_tab','offers');
				$this->getRequest()->getSession()->set('account_message',_t('MemberProfiles.OfferUnPublished', 'Ihr Angebot wurde parkiert.'));
			}
		}
		return $this->redirectBack();
	}

	public function saveOffer($data, Form $form)
	{
		if ($this->getRequest()->getSession()->get('offer_id')){
			$offer = Mission::get()->byId($this->getRequest()->getSession()->get('offer_id'));
		}
		$offer = (isset($offer)) ? $offer : new Mission();
		$form->saveInto($offer);
		//Files
		if(isset($data['TempFiles'])){
			$i = 0;
			$keys = [];

			foreach ($data['TempFiles'] as $id) {
				$p = $offer->Attachments()->byId($id);
				if(!$p){ 
					$p = File::get()->byId($id);
					if ($p){
						$folder = Folder::find_or_make($offer->getFolderName());
						$p->ParentID = $folder->ID;
						$p->write();
						$p->publishSingle();
					}
				}
				if ($p){
					$offer->Attachments()->add($p,['SortOrder' => $i]);
				}
				$keys[] = $id;
				$i++;
			}
			foreach($offer->Attachments()->exclude('ID',$keys) as $p){
				$p->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
				$p->delete();
			}
		}
		else{
			foreach($offer->Attachments() as $p){
				$p->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
				$p->delete();

			}
		}
		try {
			$offer->write();
			
			//parameters
			$config = $offer->getJobConfig();
			foreach ($config->Parameters() as $p) {
				if(isset($data[$p->Title])){
					if ($p->FieldType == "text"){
						$value = JobParameterValue::get()->filter('Title',$data[$p->Title])->first();
						if (!$value){
							$value = new JobParameterValue();
							$value->Title = $data[$p->Title];
							$value->write();
							$p->Values()->add($value);
						}
					}
					else{
						$value = JobParameterValue::get()->byId($data[$p->Title]);
					}
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
			_t('MemberProfiles.INSERATEUPDATED', 'Ihre Inserate wurde gespeichert.'),
			'good'
		);
		$this->getRequest()->getSession()->set('active_tab','offers');
		$this->getRequest()->getSession()->clear('offer_id');
		return $this->redirectBack();
	}

	public function DeleteCandidature(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$Candidature = Candidature::get()->byId($id);
			if ($Candidature && $Candidature->canDelete()){
				$Candidature->Status = 'deleted';
				$Candidature->write();
				return $this->redirect(MemberProfilePage::get()->first()->Link());
			}
		}
		
		return $this->httpError(400);
	}

//Job Sucher
	public function CandidatAccountForm(){

		$actions = new FieldList(FormAction::create('saveCandidatAccount', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$candidat = ($candidat) ? $candidat : new Candidat();
		
		$form = new Form(
			$this,
			'CandidatAccountForm',
			$candidat->getAccountFields(),
			$actions,
			$candidat->getRequiredAccountFields()
		);
		
		$form->addExtraClass('uk-form-horizontal form-std');
		$form->loadDataFrom($candidat->Member());
		$form->loadDataFrom($candidat);

		return $form;
	}

	public function saveCandidatAccount($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$form->saveInto($member);
		$form->saveInto($candidat);
	
		try {
			$member->write();
			$candidat->write();
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			$form->sessionMessage($validationMessages, 'bad');
			return $this->redirectBack();
		}
		$form->sessionMessage(
			_t('MemberProfiles.PROFILEUPDATED', 'Ihr Konto wurde aktualisiert.'),
			'good'
		);
		$this->getRequest()->getSession()->set('active_tab','account');
		
		return $this->redirectBack();
	}

	public function CandidatProfilForm(){
		$actions = new FieldList(FormAction::create('saveCandidatProfil', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$candidat = ($candidat) ? $candidat : new Candidat();
		
		$form = new Form(
			$this,
			'CandidatProfilForm',
			$candidat->getProfileFields(),
			$actions,
			$candidat->getRequiredProfileFields()
		);
		
		$form->setTemplate('Forms/CandidatProfilForm');
		$form->addExtraClass('form-std candidat-form');
		$form->loadDataFrom($candidat);

		return $form;
	}

	public function saveCandidatProfil($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$form->saveInto($candidat);

		//Files
		if(isset($data['TempFiles'])){
			$i = 0;
			$keys = [];

			foreach ($data['TempFiles'] as $id) {
				$p = $candidat->Files()->byId($id);
				if(!$p){ 
					$p = File::get()->byId($id);
					if ($p){
						$folder = Folder::find_or_make($candidat->generateFolderName());
						$p->ParentID = $folder->ID;
						$p->write();
						$p->publishSingle();
					}
					
				}
				if ($p){
					$candidat->Files()->add($p,['SortOrder' => $i]);
				}
				$keys[] = $id;
				$i++;
			}
			foreach($candidat->Files()->exclude('ID',$keys) as $p){
				$p->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
				$p->delete();
			}
		}
		else{
			foreach($candidat->Files() as $p){
				$p->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
				$p->delete();

			}
		}
	
		try {
			$candidat->write();
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

	public function CompetencesForm(){
		$actions = new FieldList(FormAction::create('saveCompetences', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$candidat = ($candidat) ? $candidat : new Candidat();
		
		$form = new Form(
			$this,
			'CompetencesForm',
			$candidat->getCompetencesFields(),
			$actions,
			$candidat->getRequiredCompetencesFields()
		);
		
		$form->setTemplate('Forms/CandidatCompetencesForm');
		$form->addExtraClass('form-std');
		$form->loadDataFrom($candidat);

		return $form;
	}

	public function getCompetences(){
		return ProfilParameter::get()->filter(['isVisible' => 1,'ParentID' => 0])->sort('Sort');
	}

	public function getAssignedCompetences(){
		$member = Security::getCurrentUser();
		if ($member){
			$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
			if ($candidat){
				return $candidat->Parameters();
			}
			
		}
		return null;
	}

	public function hasCompetence($param,$value,$isArray){
		$hasParameter = $this->getAssignedCompetences()->filter('Title',$param)->first();
		if ($hasParameter){
			if ($isArray){
				$values = explode(';-;',$hasParameter->Value);
				return in_array($value,$values);
			}
			return $value == $hasParameter->Value;
		}
		return false;
	}

	public function saveCompetences($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$candidat = Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();

		//Files
		if(isset($data['ProfilParameters'])){
			$keys = [];

			foreach ($data['ProfilParameters'] as $param => $value) {
				$assignedParam = $candidat->Parameters()->filter('Title',$param)->first();
				if(!$assignedParam){ 
					$assignedParam = new AssignedProfilParameter();
					$assignedParam->Title = $param;
					$assignedParam->CandidatID = $candidat->ID;
				}
				if (is_array($value)){
					$assignedParam->Value = implode(';-;',$value);
				}
				else{
					$assignedParam->Value = $value;
				}
				$assignedParam->write();
				$keys[] = $param;
			}
			foreach($candidat->Parameters()->exclude('Title',$keys) as $p){
				$p->delete();
			}
		}
		else{
			foreach($candidat->Parameters()() as $p){
				$p->delete();
			}
		}
		
		try {
			$candidat->write();
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
		$this->getRequest()->getSession()->set('active_tab','competences');
		
		return $this->redirectBack();
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