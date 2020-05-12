<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Permission;
use TractorCow\Fluent\Model\Locale;

class FilterLocalExtension extends DataExtension
{
    public function updateCMSFields(FieldList $fields){
        print_r('ici');
         $locales = $fields->FieldByName('Root.Locales.FilteredLocales');
         $fields->removeByName('FilteredLocales');
         if ($this->owner->ID > 0 && $locales){
         	$fields->addFieldToTab('Root.Locales',$locales);
         }
         
    }

    public function onBeforeWrite(){
    	parent::onBeforeWrite();
    	if ($this->owner->FilteredLocales()->count() == 0){
    		$defaultLocale = Locale::get()->filter('IsGlobalDefault',1)->first();
    		if ($defaultLocale){
    			$this->owner->FilteredLocales()->add($defaultLocale);
    			$this->owner->write();
    		}
    	}
    }

}