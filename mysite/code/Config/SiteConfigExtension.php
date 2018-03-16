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
    'Xing' => 'Varchar(255)',
    'FooterBackground' => 'Varchar(255)'
  ];

  private static $has_many = [
    'Blocks' => FooterBlock::class
  ];

  private static $has_one = [
    'DefaultSlide' => Image::class
  ];

      private static $backgrounds = [
        'uk-section-default' => 'keine Hintergrundfarbe',
        'uk-section-primary dk-text-hover-primary' => 'primäre Farbe',
        'uk-section-secondary dk-text-hover-secondary' => 'sekundäre Farbe',
        'uk-section-muted dk-text-hover-muted' => 'grau',
        'dk-background-white uk-section-default dk-text-hover-white' => 'weiss',
        'dk-background-black uk-section-default dk-text-hover-black' => 'schwarz'
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
    $FooterLinksField = new GridField(
        'Blocks',
        'Blocks',
        $this->owner->Blocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.Footer", DropdownField::create('FooterBackground',_t(__CLASS__.'.Background','Hintergrundfarbe'),self::$backgrounds)->setEmptyString(_t(__CLASS__.'.BackgroundHelp','Wählen Sie aus eine Hintergrundfarbe')));
    $fields->addFieldToTab("Root.Footer", $FooterLinksField);
    $fields->addFieldToTab("Root.Default", UploadField::create('DefaultSlide','Slide'));
    
    $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.MainTab','Hauptteil'));
    $fields->FieldByName('Root.Access')->setTitle(_t(__CLASS__.'.AccessTab','Zugang'));
    $fields->FieldByName('Root.Default')->setTitle(_t(__CLASS__.'.DefaultTab','Standard'));
  }

  public function activeFooterBlocks(){
    return $this->owner->Blocks()->filter('isVisible',1);
  }

}