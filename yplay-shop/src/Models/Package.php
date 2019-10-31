<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;

class Package extends Product {
	private static $db = [
	
	];

	private static $has_one = [
		'Image' => Image::class
	];

	private static $many_many = [
		'Products' => Product::class
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