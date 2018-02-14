<?php

use SilverStripe\ORM\DataExtension;


class PageBlocksExtension extends DataExtension {
	public function requireDefaultRecords(){
		parent::requireDefaultRecords();
		foreach (Page::get() as $page){
			$page->checkLead();
		}
	}

	public function checkLead(){
		$ElementalArea = $this->owner->ElementalArea(); 
		$hasLead = LeadBlock::get()->filter(array('ParentID' => $ElementalArea->ID, 'isPrimary' => 1))->count();
		if (!$hasLead){
			$lead = new LeadBlock();
			$lead->ParentID = $ElementalArea->ID;
			$lead->isPrimary = 1;
			$lead->write();
		}
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->owner->checkLead();
	}
}
