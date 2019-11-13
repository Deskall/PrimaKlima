<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class ProductItem extends DataObject {
	private static $db = [
	'Title' => 'Varchar',
	'Content' => 'HTMLText'
	];
	
	private static $summary_fields = [
		'Title',
		'Content' 
	];
	

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = 'Name';
		$labels['Content'] = 'Beschreibung';
		return $labels;
	}


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		return $fields;
	}
}