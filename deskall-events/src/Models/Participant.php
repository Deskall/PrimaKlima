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
 * @package deskall-users
 */
class Participant extends DataObject
{
    private static $db = array(
        'Name' => 'Varchar',
        'Vorname' => 'Varchar',
        'Email' => 'Varchar',
        'Company' => 'Varchar',
        'Gender'  => 'Varchar',
        'Address'  => 'Varchar',
        'Address2'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Region'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'UIDNumber' => 'Varchar'
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
    $labels['Name'] = _t(__CLASS__.'.Name','Name');
    $labels['Vorname'] = _t(__CLASS__.'.Vorname','Vorname');
    $labels['Email'] = _t(__CLASS__.'.Email','E-Mail-Adresse');
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['Gender'] = _t(__CLASS__.'.Gender','Anrede');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['Address2'] = _t(__CLASS__.'.Address2','Adresszusatz');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Region'] = _t(__CLASS__.'.Region','Kanton');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Title'] = _t(__CLASS__.'.Title','Name');
    $labels['printAddress'] = _t(__CLASS__.'.printAddress','Adresse');
    return $labels;
    }

    public function getTitle(){
        // $intro = ($this->Gender == "Frau") ? "Sehr geehrte Frau" : "Sehr geehrter Herr";
        return DBField::create_field('Varchar', $this->Gender.' '.$this->Vorname.' '.$this->Name);
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
        .i18n::getData()->getCountries()[strtolower($this->Country)].'</p>';
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