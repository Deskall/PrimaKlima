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

class SiteConfigExtension extends DataExtension 
{

  private static $db = [
    'AddressTitle' => 'Text',
    'Address' => 'Text',
    'CodeCity' => 'Varchar(255)',
    'Country' => 'Varchar(255)',
    'Email' => 'Varchar(255)',
    'Phone' => 'Varchar(255)',
    'Mobile' => 'Varchar(255)',
    'Notfall' => 'Varchar(255)',
    'Facebook' => 'Varchar(255)',
    'Twitter' => 'Varchar(255)',
    'Linkedin' => 'Varchar(255)',
    'Xing' => 'Varchar(255)'  
  ];

  public function updateCMSFields(FieldList $fields) {
     

    //ADDRESS
    $fields->addFieldsToTab('Root.Main',[
      HeaderField::create('AddressHeading',_t(__CLASS__.'.Address','Adresse'),3),
      TextareaField::create('AddressTitle',_t(__CLASS__.'.AdresseTitle','Adresse Titel')),
      TextareaField::create('Address',_t(__CLASS__.'.AddressStreet','Adresse')),
      TextField::create('CodeCity',_t(__CLASS__.'.CodeCity','PLZ / Ort')),
      TextField::create('Country',_t(__CLASS__.'.Country','Land')),
      TextField::create('Phone',_t(__CLASS__.'.Phone','Telefon')),
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
      TextField::create('Xing',_t(__CLASS__.'.Xing','Xing'))
    ]);
    
   
    
    $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.MainTab','Hauptteil'));
    $fields->FieldByName('Root.Access')->setTitle(_t(__CLASS__.'.AccessTab','Zugang'));
  }

  public function onBeforeWrite(){
    if ($this->owner->ID > 0){
            $changedFields = $this->owner->getChangedFields();
            //Update Folder Name
            if ($this->owner->isChanged('Title') && ($changedFields['Title']['before'] != $changedFields['Title']['after'])){
                $oldFolderPath = "Uploads/".URLSegmentFilter::create()->filter($changedFields['Title']['before']);
                $newFolder = Folder::find_or_make($oldFolderPath);
                $newFolder->Name = $changedFields['Title']['after'];
                $newFolder->Title = $changedFields['Title']['after'];
                $newFolder->write();
            }
        }
      
      parent::onBeforeWrite();
  }


  public function getFolderName(){
    return "Uploads/".URLSegmentFilter::create()->filter($this->owner->Title)."/Parameters";
  }
}