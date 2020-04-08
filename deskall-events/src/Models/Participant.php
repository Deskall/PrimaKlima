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

/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-events
 */
class Participant extends DataObject
{
    private static $db = array(
        'Company' => 'Varchar',
        'Gender'  => 'Varchar',
        'Name' => 'Varchar',
        'FirstName' => 'Varchar',
        'Email' => 'Varchar',
        'Birthdate' => 'Date',
        'Street' => 'Varchar',
        'Address'  => 'Varchar',
        'Region'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
     );

    private static $singular_name = "Teilnehmer";
    private static $plural_name = "Teilnehmer";

    private static $summary_fields = [
        'Title' => ['title' => 'Name'],
        'printAddress' => ['title' => 'Adresse']
    ];

    private static $has_many = [
        'Orders' => Order::class
    ];


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
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Birthdate'] = _t(__CLASS__.'.Birthdate','Geburtsdatum');
    $labels['printAddress'] = _t(__CLASS__.'.printAddress','Adresse');
    return $labels;
    }

    public function getTitle(){
        $intro = ($this->Gender == "Frau") ? "Sehr geehrte Frau" : "Sehr geehrter Herr";
        return DBField::create_field('Varchar', $intro.' '.$this->Vorname.' '.$this->Name);
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
    }

    public function onAfterWrite()
    {

        parent::onAfterWrite();
       
    }

    public function printAddress(){
        $html = '<p>'.$this->Gender.' '.$this->Vorname.' '.$this->Name.'<br/>';
        if ($this->Company){
           $html .= $this->Company.'<br/>';
        }
        $html .= $this->Address.'<br/>'
        .$this->PostalCode.' - '.$this->City.'<br/>'
        .$this->Country.'</p>'
        .'<p><a href="mailto:'.$this->Email.'">'.$this->Email.'</a>'.'<br/>'
        .$this->Phone.'</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }


    public function getCMSFields()
    {
       $fields = parent::getCMSFields();

       return $fields;
    }


}