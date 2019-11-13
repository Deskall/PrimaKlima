<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\ArrayData;

class ProductOption extends Product {
	private static $singular_name = 'Option';
	private static $plural_name = 'Optionen';

	private static $db = [
		'hasOptions' => 'Boolean(0)'
	];

	private static $has_one = ['Group' => ProductOption::class];

	private static $has_many = ['Options' => ProductOption::class];

	
	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['hasOptions'] = 'ist einen Grupp?';
		$labels['Group'] = 'Grupp';
		$labels['Options'] = 'Optionen';
		return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		if ($this->ID > 0){
			$fields->dataFieldByName('Options')->displayIf('hasOptions')->isChecked();
		}
		return $fields;
	}

	public function getCategoryTitle(){
		return $this->Category()->Title;
	}
	
}

