<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\ClassInfo;
use TractorCow\Fluent\Model\Locale;
use SilverStripe\ORM\DataList;

class PublishInDefaultLocaleExtension extends DataExtension{
	
	public function onAfterWrite(){
		parent::onAfterWrite();
		if ($this->owner->IsGlobalDefault){
			foreach(ClassInfo::subclassesFor('DataObject') as $class ) {
				if (singleton($class)->hasExtension("TractorCow\Fluent\Extension\FluentFilteredExtension")) {
					$objects = DataList::create($class);
					foreach($objects as $obj){
						if (!$obj->Locales()->exists()){
							$obj->Locales()->add($this->owner);
							$obj->write();
						}
					}
				}
			}
		}
		
	}
}