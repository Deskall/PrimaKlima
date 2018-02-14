<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;


class UserFormExtension extends DataExtension 
{
   private static $db = [
    'hasCaptcha' => 'Boolean(1)'
   ];


   public function updateCMSFields(FieldList $fields){
     $fields->addFieldToTab('Root.FormOptions',CheckboxField::create('hasCaptcha', _t(__CLASS__.'.WITHCAPTCHA', 'mit Google recaptcha Prüfung?')));
   }

}