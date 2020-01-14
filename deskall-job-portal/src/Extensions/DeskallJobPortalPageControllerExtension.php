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
    private static $allowed_actions = ['RegisterForm'];

    public function getPortal(){
       return JobPortalConfig::get()->first();
    }

    public function TestExtension(){
        return 'OK';
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
            $member = $this->owner->addMember($form);
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

            return $this->owner->redirect(MemberProfilePage::get()->filter('GroupID',$this->owner->GroupID)->first()->Link());
        }
       
        return $this->owner->redirectBack();

    }

  
}