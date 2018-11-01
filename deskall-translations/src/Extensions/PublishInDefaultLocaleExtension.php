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
			ob_start();
			foreach(ClassInfo::subclassesFor(DataObject::class) as $class ) {
				
				if (singleton($class)->hasExtension(FluentFilteredExtension::class)) {
					print_r($class."\n");
					$objects = DataList::create($class);
					
					foreach($objects as $obj){
						if (!$obj->Locales()->exists()){
							$obj->Locales()->add($this->owner);
							$obj->write();
						}
					}
				}
			}

			$result = ob_get_clean();
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
		}
		
	}
}