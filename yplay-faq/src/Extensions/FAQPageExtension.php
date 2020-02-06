<?php

use SilverStripe\ORM\DataExtension;


class FAQPageExtension extends DataExtension {
	public function activeFAQS(){
		$items = FAQItem::get()->filter('DisplayInSearchModal',1);
		
		return $items;
	}

	public function FAQPageLink(){
		$mainFAQBlock = FAQBlock::get()->filter('isMain',1)->first();
		var_dump($mainFAQBlock->ID);
		if ($mainFAQBlock){
			return $mainFAQBlock->Link();
		}
		return null;
	}
}
