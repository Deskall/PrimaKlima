<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\ClassInfo;

class PageBlocksExtension extends DataExtension {
	
	private static $db = [
		'showSlide' => 'Boolean(1)'
	];

	private static $defaults = [
		'showSlide' => 1
	];


	public function updateCMSFields(FieldList $fields){
		$fields->insertBefore('ElementalArea',HeaderField::create('BlockTitle',_t('PAGEBLOCKS.BLOCKSTITLE','Inhaltblöcke'), 3));
	}

	public function checkLead(){
		$hasLead = false;
		$PrimaryBlocks = BaseElement::get()->filter(array('isVisible' => 1, 'isPrimary' => 1));
		foreach ($PrimaryBlocks as $lead) {
			if ($lead->getRealPage() && $lead->getRealPage()->ID == $this->owner->ID){
				$hasLead = true;
			}
		}
		$ElementalArea = $this->owner->ElementalArea(); 
		// $hasLead = BaseElement::get()->filter(array('ParentID' => $ElementalArea->ID, 'isPrimary' => 1))->count();
		if (!$hasLead){
			$lead = new LeadBlock();
			$lead->ParentID = $ElementalArea->ID;
			$lead->HTML = $this->owner->Content;
			$lead->isPrimary = 1;
			$lead->Sort = 1;
			$lead->Background = 'no-bg';
			$lead->write();
		}
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		// $this->owner->checkLead();
	}

	public function onBeforeDelete(){
		parent::onBeforeDelete();
		if ($this->owner->ElementalArea()->exists()){
			$this->owner->ElementalArea()->delete();
		}
		
	}

	public function firstBlockSlide(){
		if ($this->owner->ID < 0){
			return false;
		}
		$firstBlock = $this->owner->ElementalArea()->Elements()->first();
		if (!$firstBlock){
			return false;
		}
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
