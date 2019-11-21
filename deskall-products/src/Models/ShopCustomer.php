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
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-shop
 */
class ShopCustomer extends DataObject
{
    private static $db = array(
        'Birthday' => 'Date',
        'BirthPlace' => 'Varchar',
        'Company' => 'Varchar',
        'Gender'  => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'UIDNumber' => 'Varchar',
        'PayPalID' => 'Varchar'
     );

    private static $singular_name = "Shop Kunde";
    private static $plural_name = "Shop Kunden";
    private static $groupcode = 'shop-kunden';

    private static $summary_fields = [
        'Member.Surname' => ['title' => 'Name'],
        'printContact' => ['title' => 'Adresse']
    ];

    private static $has_many = [
        'Orders' => ShopOrder::class
    ];

    private static $has_one = [
        'Member' => Member::class
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
   
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['Gender'] = _t(__CLASS__.'.Gender','Anrede');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Title'] = _t(__CLASS__.'.Title','Name');
    $labels['Birthday'] = _t(__CLASS__.'.Birthday','Geburtsdatum');
    $labels['BirthPlace'] = _t(__CLASS__.'.BirthPlace','Geburstort');
    $labels['UIDNumber'] = _t(__CLASS__.'.UIDNumber','UID-Nr.');
    $labels['printAddress'] = _t(__CLASS__.'.printAddress','Adresse');
    return $labels;
    }

    public function printTitle(){
        $intro = ($this->Gender == "Frau") ? "Sehr geehrte Frau" : "Sehr geehrter Herr";
        return DBField::create_field('Varchar', $intro.' '.$this->Member()->Firstname.' '.$this->Member()->Surname);
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
    }

    public function onAfterWrite()
    {

        parent::onAfterWrite();
       
    }

    public function printAddress(){
        $html = '<p>'.$this->Gender.' '.$this->Member()->FirstName.' '.$this->Member()->Surname.'<br/>';
        if ($this->Company){
           $html .= $this->Company.'<br/>';
        }
        $html .= $this->Address.'<br/>'
        .$this->PostalCode.' - '.$this->City.'<br/>';
        if ($this->Country){
            $html .= i18n::getData()->getCountries()[strtolower($this->Country)];
        }
         $html .= '</p>';
      
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

    public function printContact(){
        $html = '<p>'.$this->Gender.' '.$this->Member()->FirstName.' '.$this->Member()->Surname.'<br/>';
        if ($this->Company){
           $html .= $this->Company.'<br/>';
        }
        $html .= $this->Address.'<br/>'
        .$this->PostalCode.' - '.$this->City;
        if ($this->Country){
            $html .= '<br/>'.i18n::getData()->getCountries()[$this->Country];
        }
        $html .= '</p>'
        .'<p><a href="mailto:'.$this->Member()->Email.'">'.$this->Member()->Email.'</a>'.'<br/>'
        .$this->Phone.'</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }


    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('PayPalID');
       if ($this->ID > 0){
        $fields->fieldByName('Root.Orders.Orders')->getConfig()->addComponent(new GridFieldDeleteAction());
       }
       

       return $fields;
    }

    public function sendLoginData(){
        $token = $this->Member()->generateAutologinTokenAndStoreHash();
        $link = Security::getPasswordResetLink($this->Member(),$token);
        $config = SiteConfig::current_site_config();
        $email = new Email();
        $email->setFrom($config->Email);
        $email->setTo($this->Member()->Email);
        $email->setHTMLTemplate('Emails\\base_email');
        $email->setSubject(_t(__CLASS__.'.LoginEmailSubject','Schneider Mietkochagentur - Ihr Kundenkonto'));
        $html = ProductConfig::get()->first()->EmailCustomerAccountDataBody;
        $html = str_replace('$PasswortLink',$link,$html);
        $o = new DBHTMLText();
        $o->setValue($html);
        $email->setData(['Subject' =>_t(__CLASS__.'.LoginEmailSubject','Schneider Mietkochagentur - Ihr Kundenkonto'),'Lead' => '', 'Body' => $o,'Footer' => '', 'SiteConfig' => SiteConfig::current_site_config()]);
        $email->send();
    }


}