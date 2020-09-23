<?php

use SilverStripe\Core\Extension;

class DeskallElementalAreaConfigExtension extends Extension{
	
	public function updateConfig(){
		$this->owner->addComponent(new GridFieldShowHideAction());
	}
}