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
		'Duration' => 'Varchar'
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
		$labels['Value'] = _t(__CLASS__.'.Value','Discount');
		$labels['Type'] = _t(__CLASS__.'.Type','Type');
		$labels['Duration'] = _t(__CLASS__.'.Duration','Dauern');
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
		$fields->replace('Type',DropdownField::create('Type',$this->fieldLabels()['Type'],['discount' => 'Rabatt', 'replace' => 'Preis ersetzung']));
		$fields->dataFieldByName('Unit')->replace(DropdownField::create('Unit',$this->fieldLabels()['Unit'],['percent' => 'Prozentsatz', 'discount' => 'CHF'])->displayIf('Type')->isEqualTo('discount')->end());
	}


}