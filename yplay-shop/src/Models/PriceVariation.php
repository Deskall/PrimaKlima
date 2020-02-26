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
		'UniquePriceLabel' => 'Varchar',
		'ActivationPrice' => 'Currency',
		'ActivationPriceLabel' => 'Varchar'
	];

	private static $has_one = [
		'Product' => Product::class,
		'Code' => PostalCode::class
	];


	private static $summary_fields = [
		'Code',
		'Product.Title' => ['title' => 'Product']
	];


	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['UniquePrice'] = 'Einmaliger Preis';
		$labels['UniquePriceLabel'] = 'Einmaliger Preis Erklärung';
		$labels['ActivationPrice'] = 'Grundgebühr';
		$labels['ActivationPriceLabel'] = 'Grundgebühr Preis Erklärung';
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