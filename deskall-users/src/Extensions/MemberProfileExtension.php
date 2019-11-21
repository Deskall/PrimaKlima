<?php


use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Group;
use SilverStripe\Forms\FormAction;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Core\Config\Config;

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

    public function updateFieldLabels(&$labels){
        
    }
   
    
    public function canLogIn(ValidationResult $result)
    {
        if ($this->owner->inGroups(Group::get()->filter('Code',Config::inst()->get('Cook','groupdcode')))){
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
        if ($this->owner->stat('groupcode')){
            return MemberProfilePage::get()->filter('GroupID',Group::get()->filter('Code',$this->owner->stat('groupcode'))->first()->ID)->first()->Link();
        }
        return "admin/pages";
    }

    public function getCook(){
        return Cook::get()->filter('MemberID',$this->owner->ID)->first();
    }


}