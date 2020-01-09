<?php

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\GroupedList;

class SearchBarBlock extends BaseElement {
	private static $icon = 'font-icon-search';
	
	private static $controller_template = 'BlockHolder';

	private static $controller_class = BlockController::class;

	private static $help_text = "Job Suchbar";

	public function getType()
	{
	    return _t(__CLASS__ . '.BlockType', 'Job Suche');
	}

	public function getConfig(){
		return JobPortalConfig::get()->first();
	}

	public function getPositions(){
		$param = $this->getConfig()->Parameters()->filter('Title','Position')->first();
		if ($param){
			return $param->Values()->sort('Title');
		}
		return null;
	}

	public function getCities(){
		return GroupedList::create(Mission::get()->filter('isActive',1)->sort('City'));
	}
}