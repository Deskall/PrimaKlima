<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\CheckboxField;
class PriceVariation extends DataObject {

	
	private static $db = [
		'Title' => 'Varchar',
		'Unit' => 'Varchar',
		'Value' => 'Decimal',
		'Type' => 'Varchar',
		'ApplyTo' => 'Varchar',
		'AllCodes' => 'Boolean(0)',
		'AllProducts' => 'Boolean(0)'
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
		$labels['Title'] = _t(__CLASS__.'.Title','Label');
		$labels['Unit'] = _t(__CLASS__.'.Unit','Einheit');
		$labels['Value'] = _t(__CLASS__.'.Value','Discount / Neu Preis');
		$labels['Type'] = _t(__CLASS__.'.Type','Type');
		$labels['ApplyTo'] = _t(__CLASS__.'.ApplyTo','gelten für');
		$labels['Products'] = _t(__CLASS__.'.Products','Produkte');
		$labels['Packages'] = _t(__CLASS__.'.Packages','Pakete');
		$labels['Options'] = _t(__CLASS__.'.Options','Optionen');
		$labels['Codes'] = _t(__CLASS__.'.Codes','Ortschaften');
		$labels['AllCodes'] = _t(__CLASS__.'.AllCodes','gilt für alle Ortschaften?');
		$labels['AllProducts'] = _t(__CLASS__.'.AllProducts','gilt für alle Produkte?');

		return $labels;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if ($this->Codes()->count() == 0){
			$this->AllCodes = 1; 
		}
		else{
			$this->AllCodes = 0; 
		}
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ActionID');
		$fields->removeByName('Products');
		$fields->removeByName('Packages');
		$fields->removeByName('Options');
		$fields->removeByName('Codes');
		$fields->removeByName('AllCodes');
		$fields->removeByName('AllProducts');
		$fields->insertAfter('Title',DropdownField::create('Type',$this->fieldLabels()['Type'],['discount' => 'Rabatt', 'replace' => 'Preis ersetzung']));
		$fields->insertAfter('Title',DropdownField::create('Unit',$this->fieldLabels()['Unit'],['percent' => 'Prozentsatz', 'discount' => 'CHF'])->displayIf('Type')->isEqualTo('discount')->end());
		$fields->insertAfter('Title',DropdownField::create('ApplyTo',$this->fieldLabels()['ApplyTo'],['MonthlyPrice' => 'den monatlichen Preis', 'UniquePrice' => 'den einmaligen Preis', 'Fee' => 'den gebühren Preis']));
		$fields->push(CheckboxField::create('AllCodes',$this->fieldLabels(true)['AllCodes']));
		$fields->push(ListboxField::create('Codes',$this->fieldLabels(true)['Codes'],PostalCode::get()->map('ID','Code'),$this->Codes())->hideIf('AllCodes')->isChecked(true)->end());
		$fields->push(CheckboxField::create('AllProducts',$this->fieldLabels(true)['AllProducts']));
		$fields->push(ListboxField::create('Products',$this->fieldLabels(true)['Products'],Product::get()->map('ID','Title'),$this->Products())->hideIf('AllProducts')->isChecked(true)->end());
		return $fields;
	}


}