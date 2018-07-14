<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;

class PageBlocksExtension extends DataExtension {
	
	private static $db = [
		'showSlide' => 'Boolean(1)'
	];

	private static $defaults = [
		'showSlide' => 1
	];

	public function requireDefaultRecords(){
		parent::requireDefaultRecords();
		foreach (Page::get() as $page){
			$page->checkLead();
		}
	}

	public function updateCMSFields(FieldList $fields){
		$fields->insertBefore('ElementalArea',HeaderField::create('BlockTitle',_t('PAGEBLOCKS.BLOCKSTITLE','Inhaltblöcke'), 3));
	}

	public function checkLead(){
		$ElementalArea = $this->owner->ElementalArea(); 
		$hasLead = LeadBlock::get()->filter(array('ParentID' => $ElementalArea->ID, 'isPrimary' => 1))->count();
		if (!$hasLead){
			$lead = new LeadBlock();
			$lead->ParentID = $ElementalArea->ID;
			$lead->HTML = $this->owner->Content;
			$lead->isPrimary = 1;
			$lead->Sort = 1;
			$lead->write();
		}
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->owner->checkLead();
	}

	public function firstBlockSlide(){
		$firstBlock = $this->owner->ElementalArea()->Elements()->first();

		return $firstBlock->ClassName != "SliderBlock";
	}

	public function ParentSlide(){
		return (SliderBlock::get()->filter('ParentID',$this->owner->getParent()->ElementalAreaID)->first());
	}

	public function headScripts(){
		return (CodeBlock::get()->filter(['ParentID' => $this->owner->ElementalAreaID, 'Position' => 'head']));
	}

	public function BodyScripts(){
		return (CodeBlock::get()->filter(['ParentID' => $this->owner->ElementalAreaID, 'Position' => 'body']));
	}
}
