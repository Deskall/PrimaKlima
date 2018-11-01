<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\ClassInfo;
use TractorCow\Fluent\Model\Locale;
use SilverStripe\ORM\DataList;
use TractorCow\Fluent\Extension\FluentFilteredExtension;
use Silverstripe\ORM\DataObject;

class PublishInDefaultLocaleExtension extends DataExtension{
	
	public function onAfterWrite(){
		parent::onAfterWrite();
		if ($this->owner->IsGlobalDefault){
			foreach(ClassInfo::subclassesFor(DataObject::class) as $class ) {
				
				if (singleton($class)->hasExtension(FluentFilteredExtension::class)) {
					
					$objects = DataList::create($class);
					
					foreach($objects as $obj){
						if ($obj->FilteredLocales()->count() == 0){
							$obj->FilteredLocales()->add($this->owner);
							$obj->write();
						}
					}
				}
			}

			
		}
		
	}
}