<?php

use SilverStripe\ORM\DataExtension;


class MessagePageExtension extends DataExtension {
	public function activeMessages(){
		return News::get()->filter('isActive',1);
	}
}
