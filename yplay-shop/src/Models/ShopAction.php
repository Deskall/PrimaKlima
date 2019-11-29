<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ShopAction extends DataObject {

	
	private static $db = [
		'Title' => 'Varchar',
		'Lead' => 'Text',
		'Description' => 'HTMLText',
		'Start' => 'Date',
		'End' => 'Date',
		'isGlobal' => 'Boolean(0)'
		'Conditions' => 'HTMLText'
	];

	private static $has_one = [
		'Image' => Image::class,
		'Icon' => Image::class
	];

	private static $has_many = [
		'Variations' => PriceVariation::class
	];


	private static $summary_fields = [
		'Title'
	];

	private static $searchable_fields = [
		'Title'
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = _t(__CLASS__.'.Title','Titel');
		$labels['Lead'] = _t(__CLASS__.'.Lead','Lead');
		$labels['Description'] = _t(__CLASS__.'.Description','Beschreibung');
		$labels['Start'] = _t(__CLASS__.'.Start','Anfang');
		$labels['End'] = _t(__CLASS__.'.End','Ende');
		$labels['isGlobal'] = _t(__CLASS__.'.isGlobal','Global?');
		$labels['Conditions'] = _t(__CLASS__.'.Conditions','Konditionen');
		$labels['Image'] = _t(__CLASS__.'.Image','Bild');
		$labels['Icon'] = _t(__CLASS__.'.Icon','Icon');
		$labels['Variations'] = _t(__CLASS__.'.Variations','Discounts');
	
		return $labels;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	}

}