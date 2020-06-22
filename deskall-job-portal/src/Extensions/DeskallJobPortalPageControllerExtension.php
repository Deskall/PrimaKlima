<?php

use SilverStripe\ORM\DataExtension;
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

class DeskallJobPortalPageControllerExtension extends DataExtension
{
    private static $allowed_actions = ['RegisterForm','afterregistration', 'confirm'];

    private static $url_handlers = [
        'bestaetigen-sie-ihre-e-mail-adresse' => 'afterregistration',
        'confirmation/$ID' => 'confirm'
    ];

    public function getPortal(){
       return JobPortalConfig::get()->first();
    }

    public function MatchingToolPage(){
       return MatchingToolPage::get()->first();
    }

    public function RegisterForm(){
        $fields = singleton(Member::class)->getRegisterFields();
        $arbeitgeberId = Group::get()->filter('Code','arbeitgeber')->first()->ID;
        $candidateId = Group::get()->filter('Code','kandidaten')->first()->ID;
        $fields->insertBefore('FirstName',DropdownField::create('GroupID',_t('Member.RegisterGroupLabel','Warum wollen Sie registrieren?'),[$arbeitgeberId => _t('Member.RegisterGroupLabel1','Ich bin Arbeitgeber und suche Mitarbeiter'), $candidateId => _t('Member.RegisterGroupLabel2','Ich suche einen Job')])->setEmptyString('Bitte wählen')->setAttribute('class','uk-select')->addExtraClass('uk-clearfix'));

        $form = new Form(
            $this->owner,
            'RegisterForm',
            $fields,
            new FieldList(
                FormAction::create('register', _t('MemberProfiles.REGISTER', 'Jetzt registrieren'))->addExtraClass('uk-button uk-button-primary uk-float-right')->setUseButtonTag(true)
            ),
            singleton(Member::class)->getRequiredRegisterFields()
        );

        $form->addExtraClass('uk-form-horizontal form-std');
        if(is_array($this->owner->getRequest()->getSession()->get('RegisterForm'))) {
            $form->loadDataFrom($this->owner->getRequest()->getSession()->get('RegisterForm'));
        }

        return $form;
    }

    
    /**
        * Handles validation and saving new Member objects, as well as sending out validation emails.
        */
    public function register($data, Form $form)
    {
        $this->owner->getRequest()->getSession()->set('RegisterForm',$data);
        $member = Member::get()->filter('Email' , $data['Email'])->first();
        if (!$member){
            $member = $this->addMember($form);
            if (!$member) {
                return $this->owner->redirectBack();
            }

            return $this->owner->redirect('/bestaetigen-sie-ihre-e-mail-adresse');
        }
        
        if ($member->validateCanLogin()){
            if ($member->canLogin()) {
                Injector::inst()->get(IdentityStore::class)->logIn($member);
            } else {
                throw new Exception('Permission issue occurred. Was the "$member->validateCanLogin" check above this code block removed?');
            }

            return $this->owner->redirect(MemberProfilePage::get()->first()->Link());
        }
       
        return $this->owner->redirectBack();

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
        // if ($currentMember) {
        //     if ($currentMember->ID == $id) {
        //         return Security::permissionFailure($this->owner, _t(
        //             'MemberProfiles.ALREADYCONFIRMED',
        //             'Your account is already confirmed.'
        //         ));
        //     }
        //     return Security::permissionFailure($this->owner, _t(
        //         'MemberProfiles.CANNOTCONFIRMLOGGEDIN',
        //         'You cannot confirm account while you are logged in.'
        //     ));
        // }
        if (!$id ||
            !$key) {
            return $this->owner->httpError(404);
        }   

        $config = $this->getPortal();

        $confirmationTitle = $config->dbObject('ConfirmationTitle');
            /**
             * @var Member|null $member
             */
            $member = DataObject::get_by_id(Member::class, $id);
            if (!$member) {
                return $this->owner->invalidRequest('Member #'.$id.' does not exist.');
            }
            if (!$member->NeedsValidation) {
                return [
                    'Title'   => $config->dbObject('ConfirmationTitle'),
                    'Content' =>  
                        DBHTMLText::create()->setValue('Ihr konto wurde bereits bestätigt. Klicken Sie <a href="'.$member->MemberPageLink().'">hier</a> an, um auf Ihrem Konto zu zugreiffen')
                    
                 ];
            }
            if (!$member->ValidationKey) {
                return $this->owner->invalidRequest('Benutzer #'.$id.' hat keine Validierungsschlüssel.');
            }
            if ($member->ValidationKey !== $key) {
                return $this->owner->invalidRequest('Der Validierungsschlüssel stimmt nicht überein.');
            }
            // Allow member to login
            $member->NeedsValidation = 0;
            $member->ValidationKey = null;
            $validationResult = $member->validateCanLogin();
            if (!$validationResult->isValid()) {
                $this->owner->getResponse()->setStatusCode(500);
                $validationMessages = $validationResult->getMessages();
                return [
                    'Title'   => $confirmationTitle,
                    'Content' => $validationMessages ? $validationMessages[0]['message'] : _t('MemberProfiles.ERRORCONFIRMATION', 'Ein unbekannter Fehler ist aufgetreten.'),
                ];
            }
            $member->write();
            if ($member->inGroup('arbeitgeber')){
                $JobGiver = new JobGiver();
                $JobGiver->MemberID = $member->ID;
                $JobGiver->write(); 
            }
            if ($member->inGroup('kandidaten')){
                $candidat = new Candidat();
                $candidat->MemberID = $member->ID;
                $candidat->write(); 
            }
           
             
            $this->owner->extend('onConfirm', $member);

            if ($member->canLogin()) {
                Injector::inst()->get(IdentityStore::class)->logIn($member);
            } else {
                throw new Exception('Permission issue occurred. Was the "$member->validateCanLogin" check above this code block removed?');
            }

            $config = JobPortalConfig::get()->first();

            return [
                'Title'   => $config->dbObject('AfterConfirmationTitle'),
                'Content' => DBHTMLText::create()->setValue($config->parseString($config->dbObject('AfterConfirmationContent')))
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
        $member->Locale = $this->owner->Locale;
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

        if ($form->getData()['GroupID']){
            $group = Group::get()->byId($form->getData()['GroupID']);
            if ($group){
                $member->addToGroupByCode($group->Code);
            }
        }
      

        $email = MemberEmail::create($this->owner->data(), $member,$this->getPortal()->AfterRegistrationEmailFrom,$member->Email, $this->getPortal()->AfterRegistrationEmailSubject, $this->getPortal()->AfterRegistrationEmailBody);
        $email->send();
        
        return $member;
    }

  
}