<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\DropdownField;

class PriceVariation extends DataObject {

	
	private static $db = [
		'Label' => 'Varchar',
		'Unit' => 'Varchar',
		'Value' => 'Decimal',
		'Type' => 'Varchar',
		'ApplyTo' => 'Varchar'
	];

	private static $has_one = ['Action' => ShopAction::class];

	private static $many_many = [
		'Products' => Product::class,
		'Packages' => Package::class,
		'Options' => ProductOption::class,
		'Codes' => PostalCode::class
	];


	private static $summary_fields = [
		'Title'
	];

	private static $searchable_fields = [
		'Title'
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Label'] = _t(__CLASS__.'.Label','Label');
		$labels['Unit'] = _t(__CLASS__.'.Unit','Einheit');
		$labels['Value'] = _t(__CLASS__.'.Value','Discount / Neu Preis');
		$labels['Type'] = _t(__CLASS__.'.Type','Type');
		$labels['ApplyTo'] = _t(__CLASS__.'.ApplyTo','gelten für');
		$labels['Products'] = _t(__CLASS__.'.Products','Produkte');
		$labels['Packages'] = _t(__CLASS__.'.Packages','Pakete');
		$labels['Options'] = _t(__CLASS__.'.Options','Optionen');
		$labels['Codes'] = _t(__CLASS__.'.Codes','Ortschaften');
	
		return $labels;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Products');
		$fields->removeByName('Packages');
		$fields->removeByName('Options');
		$fields->removeByName('Codes');
		$fields->insertAfter('Label',[
			DropdownField::create('Type',$this->fieldLabels()['Type'],['discount' => 'Rabatt', 'replace' => 'Preis ersetzung']),
			DropdownField::create('Unit',$this->fieldLabels()['Unit'],['percent' => 'Prozentsatz', 'discount' => 'CHF'])->displayIf('Type')->isEqualTo('discount')->end(),
			DropdownField::create('ApplyTo',$this->fieldLabels()['ApplyTo'],['MonthlyPrice' => 'den monatlichen Preis', 'UniquePrice' => 'den einmaligen Preis', 'Fee' => 'den gebühren Preis'])
		]);

		return $fields;
	}


}