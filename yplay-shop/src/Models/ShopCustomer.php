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
        'Gender'  => 'Varchar',
        'Name' => 'Varchar',
        'FirstName' => 'Varchar',
        'Email' => 'Varchar',
        'Birthday' => 'Date',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'BillSameAddress' => 'Boolean(1)',
        'BillAddress'  => 'Varchar',
        'BillPostalCode'  => 'Varchar',
        'BillCity'  => 'Varchar',
        'BillCountry'  => 'Varchar'
     );

    private static $singular_name = "Kunde";
    private static $plural_name = "Kunden";
    
    private static $summary_fields = [
        'Name',
        'FirstName',
        'Email'
    ];

    private static $has_many = [
        'Orders' => ShopOrder::class
    ];

    // private static $has_one = [
    //     'Member' => Member::class
    // ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
   
    $labels['Gender'] = _t(__CLASS__.'.Gender','Anrede');
    $labels['Name'] = _t(__CLASS__.'.Name','Name');
    $labels['FirstName'] = _t(__CLASS__.'.FirstName','Vorname');
    $labels['Email'] = _t(__CLASS__.'.Email','E-Mail');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['BillAddress'] = _t(__CLASS__.'.BillAddress','Adresse (Rechnung)');
    $labels['BillPostalCode'] = _t(__CLASS__.'.BillPostalCode','PLZ (Rechnung)');
    $labels['BillCity'] = _t(__CLASS__.'.BillCity','Stadt (Rechnung)');
    $labels['BillCountry'] = _t(__CLASS__.'.BillCountry','Land (Rechnung)');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Birthday'] = _t(__CLASS__.'.Birthday','Geburtsdatum');
    $labels['printAddress'] = _t(__CLASS__.'.printAddress','Adresse');
    return $labels;
    }

    public function printTitle(){
        $intro = ($this->Gender == "Frau") ? "Sehr geehrte Frau" : "Sehr geehrter Herr";
        return DBField::create_field('Varchar', $intro.' '.$this->FirstName.' '.$this->Name);
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
    }

    public function onAfterWrite()
    {

        parent::onAfterWrite();
       
    }

    public function printAddress(){
        $html = '<p>'.$this->Gender.' '.$this->FirstName.' '.$this->Name.'<br/>';
      
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
        $html = '<p>'.$this->Gender.' '.$this->FirstName.' '.$this->Name.'<br/>';
       
        $html .= $this->Address.'<br/>'
        .$this->PostalCode.' - '.$this->City;
        if ($this->Country){
            $html .= '<br/>'.i18n::getData()->getCountries()[$this->Country];
        }
        $html .= '</p>'
        .'<p><a href="mailto:'.$this->Email.'">'.$this->Email.'</a>'.'<br/>'
        .$this->Phone.'</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }


    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       if ($this->ID > 0){
        $fields->fieldByName('Root.Orders.Orders')->getConfig()->addComponent(new GridFieldDeleteAction());
       }
       

       return $fields;
    }

}