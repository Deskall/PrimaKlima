<?php

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\ORM\ArrayList;

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
		$activeOffersCities = Mission::get()->filter('isActive')->column('City');

		return new ArrayList(array_unique($activeOffersCities));
	}
}