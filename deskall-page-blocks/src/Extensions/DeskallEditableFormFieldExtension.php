<?php

use SilverStripe\ORM\DataExtension;

class DeskallEditableFormFieldExtension extends DataExtension{
	public function onBeforeWrite(){
		if (!$this->owner->Placeholder){
			 $this->owner->Placeholder = $this->owner->Title;
			 if ($this->owner->Required){
			 	$this->Placeholder .= " *";
			 }	
		}
		parent::onBeforeWrite();
	}
}