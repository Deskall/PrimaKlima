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
	
	];

	
	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		
		return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		return $fields;
	}

	
}

