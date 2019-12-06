<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Session;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\EmailField;
use SilverStripe\ORM\ValidationException;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\View\ArrayData;
use SilverStripe\Security\Group;
use SilverStripe\Security\DefaultAdminService;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBHTMLText;

class RegisterPageController extends PageController{
	private static $allowed_actions = ['RegisterForm','afterregistration', 'confirm'];

	private static $url_handlers = [
		'bestaetigen-sie-ihre-e-mail-adresse' => 'afterregistration',
		'confirmation/$ID' => 'confirm'
	];

	public function RegisterForm(){

		$fields = singleton(Member::class)->getRegisterFields();

		$form = new Form(
			$this,
			'RegisterForm',
			$fields,
			new FieldList(
				FormAction::create('register', _t('MemberProfiles.REGISTER', 'Jetzt registrieren'))->addExtraClass('uk-button uk-button-primary uk-float-right')->setUseButtonTag(true)
			),
			singleton(Member::class)->getRequiredRegisterFields()
		);

		$form->addExtraClass('uk-form-horizontal form-std');
		if(is_array($this->getRequest()->getSession()->get('RegisterForm'))) {
			$form->loadDataFrom($this->getRequest()->getSession()->get('RegisterForm'));
		}

		return $form;
	}

	
	/**
	    * Handles validation and saving new Member objects, as well as sending out validation emails.
	    */
	public function register($data, Form $form)
	{
		$this->getRequest()->getSession()->set('RegisterForm',$data);
		$member = Member::get()->filter('Email' , $data['Email'])->first();
		if (!$member){
			$member = $this->addMember($form);
			if (!$member) {
				return $this->redirectBack();
			}

		    return $this->redirect('/bestaetigen-sie-ihre-e-mail-adresse');
		}
		
		if ($member->validateCanLogin()){
			if ($member->canLogin()) {
				Injector::inst()->get(IdentityStore::class)->logIn($member);
			} else {
				throw new Exception('Permission issue occurred. Was the "$member->validateCanLogin" check above this code block removed?');
			}

        	return $this->redirect(MemberProfilePage::get()->filter('GroupID',$this->GroupID)->first()->Link());
		}
       
        return $this->redirectBack();

    }

    /**
     * Returns the after registration content to the user.
     *
     * @return array
     */
    public function afterregistration()
    {
    	$this->getRequest()->getSession()->set('RegisterForm',null);
        return array (
            'Title'   => $this->obj('AfterRegistrationTitle'),
            'Content' => $this->obj('AfterRegistrationContent'),
            'noform' => true
        );
    }

	/**
	 * Allows the user to confirm their account by clicking on the validation link in
	 * the confirmation email.
	 *
	 * @param HTTPRequest $request
	 * @return array|HTTPResponse
	 */
	public function confirm(HTTPRequest $request)
	{
		$currentMember = Member::currentUser();
		$id = (int)$request->param('ID');
		$key = $request->getVar('key');
		if ($currentMember) {
			if ($currentMember->ID == $id) {
				return Security::permissionFailure($this, _t(
					'MemberProfiles.ALREADYCONFIRMED',
					'Your account is already confirmed.'
				));
			}
			return Security::permissionFailure($this, _t(
				'MemberProfiles.CANNOTCONFIRMLOGGEDIN',
				'You cannot confirm account while you are logged in.'
			));
		}
		if (!$id ||
			!$key) {
			return $this->httpError(404);
		}	

		$confirmationTitle = $this->data()->dbObject('ConfirmationTitle');
		    /**
		     * @var Member|null $member
		     */
		    $member = DataObject::get_by_id(Member::class, $id);
		    if (!$member) {
		    	return $this->invalidRequest('Member #'.$id.' does not exist.');
		    }
		    if (!$member->NeedsValidation) {
		        return [
		            'Title'   => $this->data()->dbObject('ConfirmationTitle'),
		            'Content' =>  
			            DBHTMLText::create()->setValue('Ihr konto wurde bereits bestätigt. Klicken Sie <a href="'.$member->MemberPageLink().'">hier</a> an, um auf Ihrem Konto zu zugreiffen')
			        
			     ];
		    }
		    if (!$member->ValidationKey) {
		    	return $this->invalidRequest('Benutzer #'.$id.' hat keine Validierungsschlüssel.');
		    }
		    if ($member->ValidationKey !== $key) {
		    	return $this->invalidRequest('Der Validierungsschlüssel stimmt nicht überein.');
		    }
		    // Allow member to login
	        $member->NeedsValidation = 0;
	        $member->ValidationKey = null;
	        $validationResult = $member->validateCanLogin();
	        if (!$validationResult->isValid()) {
	            $this->getResponse()->setStatusCode(500);
	            $validationMessages = $validationResult->getMessages();
	            return [
	                'Title'   => $confirmationTitle,
	                'Content' => $validationMessages ? $validationMessages[0]['message'] : _t('MemberProfiles.ERRORCONFIRMATION', 'Ein unbekannter Fehler ist aufgetreten.'),
	            ];
	        }
	        $member->write();

	            $JobGiver = new JobGiver();
	        	$JobGiver->MemberID = $member->ID;
	        	$JobGiver->write();
	         
	        $this->extend('onConfirm', $member);

	        if ($member->canLogin()) {
		        Injector::inst()->get(IdentityStore::class)->logIn($member);
		    } else {
		        throw new Exception('Permission issue occurred. Was the "$member->validateCanLogin" check above this code block removed?');
		    }

		    $config = JobPortalConfig::get()->first();

	        return [
	            'Title'   => $this->data()->dbObject('AfterConfirmationTitle'),
	            'Content' => $config->parseString($this->data()->dbObject('AfterConfirmationContent'))
	        ];
	       
    }

	/**
	 * @return array
	 */
	protected function invalidRequest($debugText)
	{
	    $additionalText = '';
	    if (Director::isDev()) {
	        // NOTE(Jake): 2018-05-02
	        //
	        // Only expose additional information in 'dev' mode.
	        //
	        $additionalText .= ' '.$debugText;
	    }
	    $this->getResponse()->setStatusCode(500);
	    return [
	        'Title'   => $this->data()->dbObject('ConfirmationTitle'),
	        'Content' => _t(
	            'MemberProfiles.ERRORCONFIRMATION',
	            'Ein unbekannter Fehler ist aufgetreten'
	        ).$additionalText
	    ];
	}


	/**
	    * Attempts to save either a registration or add member form submission
	    * into a new member object, returning NULL on validation failure.
	    *
	    * @return Member|null
	    */
	protected function addMember($form)
	{	
		$member = new Member();
		$form->saveInto($member);
		$member->NeedsValidation = true;
		$member->Locale = $this->Locale;
		$member->ValidationKey = sha1(mt_rand() . mt_rand());

		
		try {
			$member->write();
			
		} catch (ValidationException $e) {
			$validationMessages = '';
			foreach($e->getResult()->getMessages() as $error){
				$validationMessages .= $error['message']."\n";
			}
			
			
			$form->sessionMessage($validationMessages, 'bad');
			return null;
		}
	       // set after member is created otherwise the member object does not exist
		
		$member->addToGroupByCode($this->Group()->Code);
		$member->write();

		$email = MemberEmail::create($this->data(), $member,$this->AfterRegistrationEmailFrom,$member->Email, $this->AfterRegistrationEmailSubject, $this->AfterRegistrationEmailBody);
		$email->send();
		
		return $member;
	}


}