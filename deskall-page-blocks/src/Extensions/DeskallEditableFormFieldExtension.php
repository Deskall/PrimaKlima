<?php

use SilverStripe\ORM\DataExtension;

class DeskallEditableFormFieldExtension extends DataExtension{
	public function onBeforeWrite(){
		if (!$this->Placeholder){
			 $this->Placeholder = $this->Title;
		}	
	}
}