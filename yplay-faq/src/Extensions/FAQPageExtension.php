<?php

use SilverStripe\ORM\DataExtension;


class FAQPageExtension extends DataExtension {
	public function activeFAQS(){
		$items = FAQItem::get()->filter('DisplayInSearchModal',1);
		
		return $items;
	}

	public function FQAPageLink(){
		$mainFAQBlock = FAQBlock::get()->filter('isMain',1)->first();
		print_r($mainFAQBlock->ID);
		if ($mainFAQBlock){
			return $mainFAQBlock->Link();
		}
		return null;
	}
}
