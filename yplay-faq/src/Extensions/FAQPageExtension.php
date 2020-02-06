<?php

use SilverStripe\ORM\DataExtension;


class FAQPageExtension extends DataExtension {
	public function activeFAQS(){
		$items = FAQItem::get()->filter('DisplayInSearchModal',1);
		
		return $items;
	}
}
