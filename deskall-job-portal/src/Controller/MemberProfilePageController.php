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

	private static $allowed_actions = ['ProfilForm', 'upload', 'UploadForm', 'UpdateExistingDocument','DeleteObject', 'saveFolder', 'EditFile', 'DeleteFile', 'acceptContract','SaveTimeSheet','DeleteTimeSheet'];

	private static $url_handlers = [
		'delete-object/$ID/$OBJECT' => 'DeleteObject',
		'edit-file/$ID/$NEWNAME' => 'EditFile',
		'delete-file/$ID' => 'DeleteFile',
		'bestaetigen/auftrag/$ID/$CookID' => 'acceptContract',
		'wochen-zeiten' => 'SaveTimeSheet',
		'wochen-zeiten-loeschen' => 'DeleteTimeSheet',
	];

	public function init(){
		parent::init();

		Requirements::javascript('silverstripe/admin:client/dist/js/i18n.js');
		Requirements::add_i18n_javascript('deskall-users/javascript/lang');
		Requirements::javascript('silverstripe/admin: client/dist/js/vendor.js');
		Requirements::javascript('silverstripe/admin: client/dist/js/bundle.js');
		
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

		$actions = new FieldList(FormAction::create('save', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="fa fa-save uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
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
		$form->addExtraClass('uk-form-horizontal form-std');
		$form->loadDataFrom($JobGiver);

		return $form;
	}

	public function save($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$form->saveInto($member);
		$form->saveInto($JobGiver);

		//Files
		// if(isset($data['TempFiles'])){
		// 	$i = 0;
		// 	$keys = [];

		// 	foreach ($data['TempFiles'] as $id) {
		// 		$p = $JobGiver->Files()->byId($id);
		// 		if(!$p){ 
		// 			$p = File::get()->byId($id);
		// 			if ($p){
		// 				$folder = Folder::find_or_make($JobGiver->generateFolderName());
		// 				$p->ParentID = $folder->ID;
		// 				$p->write();
		// 				$p->publishSingle();
		// 			}
					
		// 		}
		// 		if ($p){
		// 			$JobGiver->Files()->add($p,['SortOrder' => $i]);
		// 		}
		// 		$keys[] = $id;
		// 		$i++;
		// 	}
		// 	foreach($JobGiver->Files()->exclude('ID',$keys) as $p){
		// 		$p->File->deleteFile();
  //               DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
		// 		$p->delete();
		// 	}
		// }
		// else{
		// 	foreach($JobGiver->Files() as $p){
		// 		$p->File->deleteFile();
  //               DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
		// 		$p->delete();

		// 	}
		// }
	
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
		
		return $this->redirectBack();
	}

	public function AccountForm(){
		Requirements::javascript("deskall-job-portal/javascript/tinymce/tinymce.min.js");



		$actions = new FieldList(FormAction::create('save', _t('MemberProfiles.SAVE', 'Speichern'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="fa fa-save uk-margin-small-right"></i>'._t('MemberProfiles.SAVE', 'Speichern')));
		$JobGiver = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$JobGiver = ($JobGiver) ? $JobGiver : new JobGiver();



		
		
		$form = new Form(
			$this,
			'ProfilForm',
			$JobGiver->getAccountFields(),
			$actions,
			$JobGiver->getRequiredAccountFields()
		);
		
		// $form->setTemplate('Forms/ProfilForm');
		$form->addExtraClass('uk-form-horizontal form-std');
		$form->loadDataFrom($JobGiver);

		return $form;
	}

	public function requireApproval($data, Form $form)
	{

		$member = Security::getCurrentUser();
		$cook = Cook::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		$form->saveInto($member);
		$form->saveInto($cook);
		$requiredFiles = ['CV','Licence','HACCPCertificat','Ausweis'];
		$missingFiles = [];

		foreach ($requiredFiles as $file) {
			
			if (!$cook->{$file}()->exists()){
				$missingFiles[] = $file;
			}
		}

		if (!empty($missingFiles)){
			$data = "\n";
			foreach ($missingFiles as $key => $value) {
				$data .= ' - '.$cook->fieldLabels(true)[$value]."\n";
			}
			$form->sessionMessage(
				_t('MemberProfiles.MISSINGDATA', 'Bitte legen Sie folgende Unterlagen vor: {data}', ['data' => $data]),
				'bad'
			);
		}
		else{
			//Files
			if(isset($data['TempFiles'])){
				$i = 0;
				$keys = [];

				foreach ($data['TempFiles'] as $id) {
					$p = $cook->Files()->byId($id);
					if(!$p){
						$p = Image::get()->byId($id);
						$folder = Folder::find_or_make($cook->generateFolderName());
						$p->ParentID = $folder->ID;
						$p->write();
						$p->publishSingle();
					}
					$cook->Files()->add($p,['SortOrder' => $i]);
					$keys[] = $id;
					$i++;
				}
				foreach($cook->Files()->exclude('ID',$keys) as $p){
					$p->File->deleteFile();
	                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
					$p->delete();
				}
			}
			else{
				foreach($cook->Files() as $p){
					$p->File->deleteFile();
	                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($p->ID));
					$p->delete();

				}
			}

			try {
				$member->Status = "waitForApproval";
				$member->write();
				$cook->write();
				$this->sendApprovalEmail($member);
			} catch (ValidationException $e) {
				$validationMessages = '';
				foreach($e->getResult()->getMessages() as $error){
					$validationMessages .= $error['message']."\n";
				}
				$form->sessionMessage($validationMessages, 'bad');
				return $this->redirectBack();
			}
			$form->sessionMessage(
				_t('MemberProfiles.PROFILEESEND', 'Ihre Profil wurde für Genehmigung gesendet.'),
				'good'
			);
		}

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

	
	public function SessionData($key){
		$data = $this->getRequest()->getSession()->get($key);
		$this->getRequest()->getSession()->set($key,'');
		return $data;
	}

	public function acceptContract(HTTPRequest $request){
		$config = CookConfig::get()->first();
		if ($request->param('ID') && $request->param('CookID')){
			$mission = Mission::get()->byId($request->param('ID'));
			$cook = Cook::get()->byId($request->param('CookID'));
			if ($mission && $cook){
				if ( $cook->canApproveContract($mission)){
					$mission->confirmedByCook();
					return ['Title' => 'Auftrag genehmigt', 'Content' =>  $mission->parseString($config->CookContractSignedText)];
				}
				return $this->redirectBack();
			}
		}
		
		return $this->httpError(404);
	}

	public function SaveTimeSheet(HTTPRequest $request){
		$vars = $request->postVars();

		$cook = Cook::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
		if ($cook && isset($vars['WeekId']) && isset($vars['fileId'])){
			$week = Week::get()->byId($vars['WeekId']);
			$file = File::get()->byId($vars['fileId']);
			if ($week && $file){
				$week->{'File.ID'} = $file->ID;
				$week->FileID = $file->ID;
				$week->write();
				$folder = Folder::find_or_make($cook->generateFolderName().'/Auftraege/'.$week->MissionID);
				$file->ParentID = $folder->ID;
				$file->write();

				return json_encode(['status' => 'OK']);
			}
		}
		return json_encode(['status' => 'not found']);
	}

	public function DeleteTimeSheet(HTTPRequest $request){
		$vars = $request->postVars();
		if (isset($vars['fileId'])){
			$file = File::get()->byId($vars['fileId']);
			if ($file){
				$file->File->deleteFile();
				DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($file->ID));
				$file->delete();

				return json_encode(['status' => 'OK']);
			}
		}
		return json_encode(['status' => 'not found']);
	}

}