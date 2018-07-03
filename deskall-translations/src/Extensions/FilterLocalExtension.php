<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Permission;

class FilterLocalExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields){
         $locales = $fields->FieldByName('Root.Locales.FilteredLocales');
         $fields->removeByName('FilteredLocales');
         if ($this->owner->ID > 0){
         	$fields->addFieldToTab('Root.Locales',$locales);
         }
         
    }

}