<?php

use SilverStripe\ORM\DataExtension;

class DeskallElementalAreaConfigExtension extends DataExtension{
	
	public function updateConfig(){
		$this->owner->addComponent(new GridFieldShowHideAction());
	}
}