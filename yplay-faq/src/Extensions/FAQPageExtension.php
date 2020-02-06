<?php

use SilverStripe\ORM\DataExtension;


class FAQPageExtension extends DataExtension {
	public function activeFAQS(){
		$items = FAQItem::get()->filter('DisplayInSearchModal',1);
		
		return $items;
	}

	public function FQAPage(){
		$mainFAQBlock = FAQBlock::get()->filter('isMain',1)->first();
		if ($mainFAQBlock){
			return $mainFAQBlock->getRealPage();
		}
		return null;
	}
}
