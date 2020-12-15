<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataExtension;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Folder;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Subsites\Extensions\SiteTreeSubsites;

class SiteConfigExtension extends DataExtension 
{

  private static $db = [
    'AddressTitle' => 'Text',
    'Address' => 'Text',
    'Code' => 'Varchar(255)',
    'City' => 'Varchar(255)',
    'Country' => 'Varchar(255)',
    'Email' => 'Varchar(255)',
    'Phone' => 'Varchar(255)',
    'Fax' => 'Varchar(255)',
    'Mobile' => 'Varchar(255)',
    'Notfall' => 'Varchar(255)',
    'Facebook' => 'Varchar(255)',
    'Twitter' => 'Varchar(255)',
    'Linkedin' => 'Varchar(255)',
    'Xing' => 'Varchar(255)' ,
    'Instagram' => 'Varchar(255)'
  ];

  private static $has_one = ['Folder' => Folder::class];

  public function updateCMSFields(FieldList $fields) {
     
    $fields->removeByName('Folder');

    //ADDRESS
    $fields->addFieldsToTab('Root.Main',[
      HeaderField::create('AddressHeading',_t(__CLASS__.'.Address','Adresse'),3),
      TextareaField::create('AddressTitle',_t(__CLASS__.'.AdresseTitle','Adresse Titel')),
      TextareaField::create('Address',_t(__CLASS__.'.AddressStreet','Adresse')),
      TextField::create('Code',_t(__CLASS__.'.Code','PLZ')),
      TextField::create('City',_t(__CLASS__.'.City','Ort')),
      TextField::create('Country',_t(__CLASS__.'.Country','Land')),
      TextField::create('Phone',_t(__CLASS__.'.Phone','Telefon')),
      TextField::create('Fax',_t(__CLASS__.'.Fax','Fax')),
      TextField::create('Mobile',_t(__CLASS__.'.Mobile','Mobile')),
      TextField::create('Notfall',_t(__CLASS__.'.Notfall','Notfall Nummer')),
      EmailField::create('Email',_t(__CLASS__.'.Email','E-Mail Adresse'))
    ]);
    //SOCIAL
    $fields->addFieldsToTab('Root.Main',[
      HeaderField::create('SocialHeading',_t(__CLASS__.'.SocialTitle','Netwerk'),3),
      TextField::create('Facebook',_t(__CLASS__.'.Facebook','Facebook')),
      TextField::create('Twitter',_t(__CLASS__.'.Twitter','Twitter')),
      TextField::create('Linkedin',_t(__CLASS__.'.Linkedin','Linkedin')),
      TextField::create('Xing',_t(__CLASS__.'.Xing','Xing')),
      TextField::create('Instagram',_t(__CLASS__.'.Instagram','Instagram'))
    ]);
    
   
    
    $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.MainTab','Hauptteil'));
    $fields->FieldByName('Root.Access')->setTitle(_t(__CLASS__.'.AccessTab','Zugang'));
  }

  public function onBeforeWrite(){
    if ($this->owner->FolderID == 0){
      $folderName = 
        ($this->owner->hasExtension('SilverStripe\Subsites\Extensions\SiteConfigSubsites')) ? 
          "Uploads/".URLSegmentFilter::create()->filter($this->owner->Title) : 
          "Uploads"
      ;
      $folder = Folder::find_or_make($folderName);
      $this->owner->FolderID = $folder->ID;
    }
    parent::onBeforeWrite();
  }

  public function onAfterWrite(){
    if ($this->owner->ID > 0){
      if ($this->owner->hasExtension('SilverStripe\Subsites\Extensions\SiteConfigSubsites')){
        $changedFields = $this->owner->getChangedFields();
        //Update Folder Name if needed
        if ($this->owner->isChanged('Title')){
            $this->owner->Folder()->Name = URLSegmentFilter::create()->filter($changedFields['Title']['after']);
            $this->owner->Folder()->write();
        }
      }
    }
    parent::onAfterWrite();
  }

  public function FormattedNumber($number){
    return str_replace(' ','',$number);
  }


  public function getFolderName(){
    return $this->owner->Folder()->Name;
  }
}