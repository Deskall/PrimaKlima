<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;

class UserFormExtension extends DataExtension 
{

    private static $controller_template = 'DefaultHolder';

    private static $description = 'Formular';

   
    
   private static $db = [
    'hasCaptcha' => 'Boolean(1)',
    'ButtonBackground' => 'Varchar(255)',
    'ShowLabels' => 'Boolean(0)' 
   ];

   private static $cascade_duplicates = [];

   private static $has_one = [
   	'RedirectPage' => SiteTree::class
   ];

   private static $controller_class = ElementFormControllerExtension::class;

   public function updateCMSFields(FieldList $fields){
    $fields->removeByName('Layout');

     $fields->addFieldToTab('Root.FormOptions',CheckboxField::create('hasCaptcha', _t(__CLASS__.'.WITHCAPTCHA', 'mit Google recaptcha Prüfung?')));
     $fields->addFieldToTab('Root.FormOptions',CheckboxField::create('ShowLabels', _t(__CLASS__.'.ShowLabels', 'Feld Titel anzeigen?')));
     $fields->fieldByName('Root.Main.RedirectPageID')->setTitle(_t(__CLASS__.'.RedirectPage', 'erfolgreiche Einreichungsseite'));
     $fields->addFieldToTab('Root.LayoutTab',HTMLDropdownField::create('ButtonBackground',_t(__CLASS__.'.ButtonBackground','Button Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors()));
     if ($this->owner->ID == 0){ 
      $fields->removeByName('FormFields');
      $fields->removeByName('Submissions');
      $fields->removeByName('FormOptions');
      $fields->removeByName('Recipients');
     }
   
   }

  public function getType()
  {
    return _t(__CLASS__ . '.BlockType', 'Formular');
  }

}