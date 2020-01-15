<?php


use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Group;
use SilverStripe\Forms\FormAction;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Security\Security;

/**
 * Adds validation fields to the Member object, as well as exposing the user's
 * status in the CMS.
 *
 * @package silverstripe-memberprofiles
 */
class MemberProfileExtension extends DataExtension
{
    private static $db = array(
        'ValidationKey'   => 'Varchar(40)',
        'NeedsValidation' => 'Boolean'
    );

    private static $register_fields = ['FirstName','Surname','Email','Password'];

    public function updateFieldLabels(&$labels){
        
    }

    public function getRegisterFields(){
        $fields = $this->owner->getMemberFormFields();
        foreach($fields as $field){
            if (!in_array($field->Name,$this->owner->stat('register_fields'))){
                $fields->removeByName($field->Name);
            }
            $fields->replaceField('Email',EmailField::create('Email','Email'));
        }

        $fields->push(CheckboxField::create('AGB',DBField::create_field(
        'HTMLFragment','<span class="uk-text-small uk-margin-remove">Hiermit bestätige ich, dass ich sowohl <a href="/" target="_blank">die Datenschutzerklärung</a> wie auch die AGB gelesen habe und mit beiden einverstanden bin.</span>'))
        ->setFieldHolderTemplate('deskall-page-blocks/templates/SilverStripe/Forms/FullWidthCheckboxField_holder'));

        return $fields;
    }


    public function getRequiredRegisterFields(){
        return new RequiredFields(['FirstName','Surname','Email','Password','AGB']);
    }
   
    
    public function canLogIn(ValidationResult $result)
    {
        if ($this->owner->inGroups(Group::get()->filter('Code',['kandidaten','arbeitgeber']))){
            if ($this->owner->NeedsValidation) {
                $result->addError(_t(
                    'MemberProfiles.NEEDSVALIDATIONTOLOGIN',
                    'You must validate your email in order to log in'
                ));
            }
        }
       
    }

    /**
     * Allows admin users to manually confirm a user.
     */
    public function saveManualEmailValidation($value)
    {
        if ($value === 'confirm') {
            $this->owner->NeedsValidation = false;
        } elseif ($value === 'resend') {
            $page = RegisterPage::get()->first();
            $email = MemberEmail::create($page, $this->owner,$page->AfterRegistrationEmailFrom,$this->owner->Email, $page->AfterRegistrationEmailSubject, $page->AfterRegistrationEmailBody);
            $email->send();
        }
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
    }

    public function onAfterWrite()
    {
        
        parent::onAfterWrite();
       
    }

    public function updateMemberFormFields($fields)
    {
        $fields->removeByName('ValidationKey');
        $fields->removeByName('NeedsValidation');
       
       
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('ValidationKey');
        $fields->removeByName('NeedsValidation');

       
        $fields->removeByName('ConfirmationHeader');
        $fields->removeByName('ConfirmationNote');


        if ($this->owner->NeedsValidation) {
            $fields->addFieldsToTab('Root.Main', array(
            new HeaderField('ConfirmationHeader', _t('MemberProfiles.EMAILCONFIRMATION', 'Confirmation Email')),
            new LiteralField('ConfirmationNote', '<p>' . _t(
                'MemberProfiles.NOLOGINTILLCONFIRMED',
                'Stakeholder can\'t login if their email is not verified'
            ) . '</p>'),
            new DropdownField('ManualEmailValidation', '', array (
                'unconfirmed' => _t('MemberProfiles.UNCONFIRMED', 'unconfirmed'),
                'resend'      => _t('MemberProfiles.RESEND', 'Resend a validation email'),
                'confirm'     => _t('MemberProfiles.MANUALLYCONFIRM', 'Manualy confirm this Stakeholder')
            ))
            ));
        }
    }


    public function MemberPageLink(){
        if ($this->owner->inGroup('arbeitgeber') || $this->owner->inGroup('kandidaten') ){
            return MemberProfilePage::get()->first()->Link();
        }
        return "admin/pages";
    }

    public function ResetPassword(){
        return Security::singleton()->Link('changepassword');
    }


}