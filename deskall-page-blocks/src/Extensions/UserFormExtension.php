<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Model\SiteTree;

class UserFormExtension extends DataExtension 
{

    private static $controller_template = 'DefaultHolder';

    private static $description = 'Formular';

   
    
   private static $db = [
    'hasCaptcha' => 'Boolean(1)'
   ];

   private static $cascade_duplicates = [];

   private static $has_one = [
   	'RedirectPage' => SiteTree::class
   ];

   private static $controller_class = ElementFormControllerExtension::class;

   public function updateCMSFields(FieldList $fields){

     $fields->addFieldToTab('Root.FormOptions',CheckboxField::create('hasCaptcha', _t(__CLASS__.'.WITHCAPTCHA', 'mit Google recaptcha Prüfung?')));
     $fields->fieldByName('Root.Main.RedirectPageID')->setTitle(_t(__CLASS__.'.RedirectPage', 'erfolgreiche Einreichungsseite'));
   
   }

  public function getType()
  {
    return _t(__CLASS__ . '.BlockType', 'Formular');
  }

}