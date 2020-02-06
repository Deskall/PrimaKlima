<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class MessagePageExtension extends DataExtension {
	public function activeFAQS(){
		$items = FAQItem::get()->filter('DisplayInSearchModal',1);
		
		return $items;
	}
}
