<?php

use SilverStripe\ORM\DataExtension;

class DeskallElementalAreaConfigExtension extends DataExtension{
	
	public function updateConfig(){
		ob_start();
					print_r('ici');
					$result = ob_get_clean();
					file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
		$this->owner->addComponent(new GridFieldShowHideAction());
	}
}