<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\CheckboxField;

class PriceVariation extends DataObject {

	
	private static $db = [
		'Price' => 'Currency',
		'UniquePrice' => 'Currency',
		'ActivationPrice' => 'Currency',
	];

	private static $has_one = [
		'Product' => Product::class,
		'Code' => PostalCode::class
	];


	private static $summary_fields = [
		'Code',
		'Price',
		'UniquePrice',
		'ActivationPrice',
	];


	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['UniquePrice'] = 'Einmaliger Preis';
		$labels['ActivationPrice'] = 'Grundgebühr';
		$labels['Price'] = 'Preis';
		$labels['Product'] = 'Produkt';
		$labels['Code'] = 'Ortschaft';

		return $labels;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		return $fields;
	}

}