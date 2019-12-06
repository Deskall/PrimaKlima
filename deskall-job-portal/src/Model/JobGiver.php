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
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\i18n\i18n;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\DB;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-users
 */
class JobGiver extends DataObject
{
    private static $db = array(
        'Company' => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'Fax'  => 'Varchar',
        'URL'  => 'Varchar',
        'SocialFacebook' => 'Varchar(255)',
        'SocialTwitter' => 'Varchar(255)',
        'SocialInstagram' => 'Varchar(255)',
        'SocialPinterest' => 'Varchar(255)',

        'ContactPersonTelephone' => 'Varchar(255)',
        'ContactPersonMobile' => 'Varchar(255)',
        'ContactPersonEmail' => 'Varchar(255)',

        'BillingAddressIsCompanyAddress' => 'Boolean',
        'BillingAddressCompany' => 'Varchar(255)',
        'BillingAddressStreet' => 'Varchar(255)',
        'BillingAddressPostalCode' => 'Varchar(255)',
        'BillingAddressPlace' => 'Varchar(255)',
        'BillingAddressCountry' => 'Varchar(255)',      
        'Cipher' => 'Varchar(255)', 
        'ReasonWhy' => 'HTMLText',  
        'FlatrateEndDate' => 'Date',
     );

    private static $singular_name = "Arbeitgeber";
    private static $plural_name = "Arbeitgeber";

    private static $groupcode = 'arbeitgeber';

    private static $default_sort = ['Created' => 'DESC'];

    private static $has_one = [
        'Member' => Member::class,
        'Logo' => Image::class
    ];

    private static $has_many = [
        'Missions' => Mission::class
    ];

    private static $defaults = [
        'BillingAddressIsCompanyAddress' => 1
    ];

   private static $summary_fields = array(
        'generateClientNumber' => 'Kundennummer',
        'Company' => 'Firma',
        'City' => 'Ort',
    );

    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
     $labels['Created'] = _t(__CLASS__.'.Created','Erstellt am');
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Missions'] = _t(__CLASS__.'.Missions','Stellenangebote');

    $labels['SocialFacebook'] = _t(__CLASS__.'.SocialFacebook','Facebook');
    $labels['SocialTwitter'] = _t(__CLASS__.'.SocialTwitter','Twitter');
    $labels['SocialInstagram'] = _t(__CLASS__.'.SocialInstagram','Instagram');
    $labels['SocialPinterest'] = _t(__CLASS__.'.SocialPinterest','Pinterest');
    $labels['ContactPersonTelephone'] = _t(__CLASS__.'.ContactPersonTelephone','Telefon');
    $labels['ContactPersonMobile'] = _t(__CLASS__.'.ContactPersonMobile','Mobil');
    $labels['ContactPersonEmail'] = _t(__CLASS__.'.ContactPersonEmail','E-Mail');

    $labels['ContactPersonTelephone'] = _t(__CLASS__.'.ContactPersonTelephone','Telefon');
    $labels['ContactPersonMobile'] = _t(__CLASS__.'.ContactPersonMobile','Mobil');
    $labels['ReasonWhy'] = _t('ARBEITGEBER.ReasonWhy', 'Warum sollten Sie bei uns arbeiten?');

    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
    }

    public function onAfterWrite()
    {

        parent::onAfterWrite();
       
    }

    public function generateClientNumber(){
        $config = SiteConfig::current_site_config();
        return number_format ( $this->ID + $SiteConfig->ClientNumberOffset , 0 ,  "." ,  "." );
    }   


    public function NiceAddress(){
        $html = '<p>';
        if ($this->Company){
            $html .= $this->Company.'<br/>';
        }
        if ($this->Address){
            $html .= $this->Address.'<br/>';
        }
        
        $html .= $this->PostalCode.' - '.$this->City.'</p>'
        .'<p><a href="mailto:'.$this->Member()->Email.'">'.$this->Member()->Email.'</a>'.'<br/>'
        .$this->Telefon.'</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();

       $fields->removeByName('BlogPosts');
       $fields->removeByName('Permissions');
       $fields->FieldByName('Root.Main')->setTitle('Kunden Daten');

       return $fields;
    }


    public function generateFolderName(){
        return "Uploads/Arbeitgeber/".$this->ID;
    }

    public function getTitle(){
        $str = $this->Company;
        if( $this->City ){
            $str .= ', '.$this->City;
        }
        return $str;
    }


    public function getProfileFields(){
        $fields = FieldList::create();
        $fields->push(CompositeField::create(
            UploadField::create('Logo','Logo')->setFolderName($this->generateFolderName())->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif', 'svg'))),
            HeaderField::create('TitleSocial', _t('ARBEITGEBER.TitleSocial', 'Online Kanäle'), 3), 
            TextField::create('URL', _t('ARBEITGEBER.Homepage', 'Homepage')), 
            TextField::create('SocialFacebook', _t('ARBEITGEBER.SocialFacebook', 'Facebook')), 
            TextField::create('SocialTwitter', _t('ARBEITGEBER.SocialTwitter', 'Twitter')), 
            TextField::create('SocialInstagram', _t('ARBEITGEBER.SocialInstagram', 'Instagram')), 
            TextField::create('SocialPinterest', _t('ARBEITGEBER.SocialPinterest', 'Pinterest')), 



            HeaderField::create('TitleOffers', _t('ARBEITGEBER.TitleOffers', 'Angebot'), 3), 



            // ListboxField::create('Offers', _t('ARBEITGEBER.Offers', 'Was wir bieten'), $Employer->ConfigurationSet()->Offers()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true'), 
            // ListboxField::create('Infrastructure', _t('ARBEITGEBER.Infrastructure', 'Infrastruktur'), $Employer->ConfigurationSet()->Infrastructure()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true'), 
            TextareaField::create('ReasonWhy', _t('ARBEITGEBER.ReasonWhy', 'Warum sollten Sie bei uns arbeiten?'))->setAttribute('data-tinymce', true)
        ));

        // $fields->replaceField('Country',DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));
        
        return $fields;
    }

    public function getRequiredProfileFields(){
       
        return new RequiredFields(['Company','Address','City','PostalCode','Land']);
    }

}