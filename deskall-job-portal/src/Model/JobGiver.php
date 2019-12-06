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

/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-users
 */
class JobGiver extends DataObject
{
    private static $db = array(
        'Company' => 'Varchar',
        'Gender'  => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'Fax'  => 'Varchar',
        'URL'  => 'Varchar'
     );

    private static $singular_name = "Arbeitgeber";
    private static $plural_name = "Arbeitgeber";

    private static $groupcode = 'arbeitgeber';

    private static $default_sort = ['Created' => 'DESC'];

    private static $has_one = [
        'Member' => Member::class
    ];

    private static $has_many = [
        'Missions' => Mission::class
    ];

    private static $summary_fields = [
        'Created',
        'Member.FirstName' => ['title' => 'Vorname'],
        'Member.Surname' => ['title' => 'Name'],
        'Member.Email' => ['title' => 'Email'],
        'Company',
        'City',
        'Country'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
     $labels['Created'] = _t(__CLASS__.'.Created','Erstellt am');
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['Gender'] = _t(__CLASS__.'.Gender','Anrede');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Missions'] = _t(__CLASS__.'.Missions','Aufträge');
    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
    }

    public function onAfterWrite()
    {

        parent::onAfterWrite();
       
    }

    public function NiceAddress(){
        $html = '<p>'.$this->Member()->getTitle().'<br/>';
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


    public function getProfileFields(){
        $fields = $this->getFrontEndFields();
        $fields->removeByName('MemberID');
        $fields->replaceField('Country',DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));

        return $fields;
    }

    public function getRequiredProfileFields(){
       
        return new RequiredFields(['Company']);
    }

}