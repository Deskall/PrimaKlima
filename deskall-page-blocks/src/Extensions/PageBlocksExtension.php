<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CompositeField;
use DNADesign\Elemental\Models\BaseElement;

class PageBlocksExtension extends DataExtension {
	
	private static $db = [
		'showSlide' => 'Boolean(1)',
        'BlockAlignment' => 'Varchar'
	];

	private static $defaults = [
		'showSlide' => 1
	];

	private static $block_alignments = [
	    'uk-flex uk-flex-left' =>  [
	        'value' => 'uk-flex uk-flex-left',
	        'title' => 'Links Ausrichtung',
	        'icon' => '/deskall-page-blocks/images/icon-block-left.svg'
	    ],
	    'uk-flex uk-flex-right' => [
	        'value' => 'uk-flex uk-flex-right',
	        'title' => 'Rechts Ausrichtung',
	        'icon' => '/deskall-page-blocks/images/icon-block-right.svg'
	    ],
	    'uk-flex uk-flex-center' =>  [
	        'value' => 'uk-flex uk-flex-center',
	        'title' => 'Mittel Ausrichtung',
	        'icon' => '/deskall-page-blocks/images/icon-block-center.svg'
	    ],
	    'uk-flex uk-flex-between' =>  [
	        'value' => 'uk-flex uk-flex-between',
	        'title' => 'Fügen Sie diese Klasse hinzu, um Elemente gleichmäßig zu verteilen, wobei der Abstand zwischen den Elementen entlang der Hauptachse gleich ist.',
	        'icon' => '/deskall-page-blocks/images/icon-block-between.svg'
	    ],
	     'uk-flex uk-flex-around' =>  [
	        'value' => 'uk-flex uk-flex-around',
	        'title' => 'Fügen Sie diese Klasse hinzu, um Artikel auf beiden Seiten gleichmäßig zu verteilen.',
	        'icon' => '/deskall-page-blocks/images/icon-block-around.svg'
	    ]
	];

	public function requireDefaultRecords(){
		parent::requireDefaultRecords();
		foreach (Page::get() as $page){
			$page->checkLead();
		}
	}

	public function updateCMSFields(FieldList $fields){
		$fields->removeByName('BlockAlignment');
		$fields->insertBefore('ElementalArea',HeaderField::create('BlockTitle',_t('PAGEBLOCKS.BLOCKSTITLE','Inhaltblöcke'), 3));
		$fields->addFieldToTab('Root.Layout',CompositeField::create(
		    // HTMLOptionsetField::create('BlocksPerLine',_t(__CLASS__.'.BlocksPerLine','Blöcke per Linie'),$this->stat('blocks_per_line')),
		    HTMLOptionsetField::create('BlockAlignment',_t(__CLASS__.'.BlockAlignment','Blockausrichtung'),$this->owner->stat('block_alignments'))->setDescription(_t(__CLASS__.'.BlockAlignmentLabel','Nur gültig wenn die Blöcke per Linie nehmen nicht die ganze Breite.'))
		);
	}

	public function checkLead(){
		$hasLead = false;
		$PrimaryBlocks = BaseElement::get()->filter(array('isVisible' => 1, 'isPrimary' => 1));
		foreach ($PrimaryBlocks as $lead) {
			if ($lead->getRealPage()->ID == $this->owner->ID){
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
			$lead->write();
		}
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->owner->checkLead();
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
