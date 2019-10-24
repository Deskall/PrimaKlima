<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;

class Product extends DataObject {
	private static $db = [
	'ProductCode' => 'Varchar',
	'Title' => 'Varchar',
	'MonthlyPrice' => 'Currency',
	'UniquePrice' => 'Currency',
	'UniquePriceLabel' => 'Varchar',
	'Unit' => 'Varchar',
	'RecurringPrice' => 'Boolean(1)',
	'Subtitle' => 'Text',
	'Description' => 'HTMLText'
	];

	private static $has_one = [
		'Category' => ProductCategory::class
	];

	private static $extensions = [
		'Sortable',
		'Activable'
	];

	private static $summary_fields = [
		'Title',
		'Subtitle',
		'PrintPriceString'
	];

	public function onBeforeWrite(){
	    if (!$this->ProductCode){
	    	$this->ProductCode = URLSegmentFilter::create()->filter($this->Title);
	    }
		parent::onBeforeWrite();
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ProductCode');
		return $fields;
	}

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = 'Name';
		$labels['Subtitle'] = 'Untertitel';
		$labels['Description'] = 'Beschreibung';
		$labels['UniquePrice'] = ($this->RecurringPrice) ? 'Einmaliger Preis' : 'Preis';
		$labels['MonthlyPrice'] = 'Montalicher Preis';
		$labels['Unit'] = 'Einheit';
		$labels['RecurringPrice'] = 'Monatlicher Preis?';

		return $labels;
	}

	public function PrintPriceString(){
		if ($this->RecurringPrice){
			return DBText::create()->setValue('CHF '.$this->MonthlyPrice.' / Mt.');
		}
	}
}