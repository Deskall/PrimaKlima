<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\ClassInfo;
use TractorCow\Fluent\Model\Locale;
use SilverStripe\ORM\DataList;
use TractorCow\Fluent\Extension\FluentFilteredExtension;

class PublishInDefaultLocaleExtension extends DataExtension{
	
	public function onAfterWrite(){
		parent::onAfterWrite();
		if ($this->owner->IsGlobalDefault){
			ob_start();

			foreach(ClassInfo::subclassesFor(DataObject::class) as $class ) {
				if (singleton($class)->hasExtension(FluentFilteredExtension::class)) {
					$objects = DataList::create($class);
					print_r($class."\n");
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