<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;

class ProductItem extends DataObject {
	private static $db = [
	'Title' => 'Varchar',
	'Content' => 'HTMLText'
	];

	private static $has_one = [
		'Parent' => DataObject::class
	];

	
	private static $summary_fields = [
		'Title',
		'Content' 
	];

	private $castings = [
		"Title" => 'Text',
		"Content" => 'HTMLText'
	];
	

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = 'Name';
		$labels['Content'] = 'Beschreibung';
		return $labels;
	}


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ParentID');
		return $fields;
	}
}