<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\ArrayData;

class ProductOption extends Product {
	private static $singular_name = 'Option';
	private static $plural_name = 'Optionen';

	private static $db = [
		'hasOptions' => 'Boolean(0)'
	];

	private static $has_one = ['Group' => ProductOption::class];

	private static $has_many = ['Options' => ProductOption::class];

	
	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['hasOptions'] = 'ist einen Grupp?';
		$labels['Group'] = 'Grupp';
		$labels['Options'] = 'Optionen';
		return $labels;
	}

	
	'ProductCode' => 'Varchar',
	'Title' => 'Varchar',
	'Subtitle' => 'Text',
	'BestSeller' => 'Boolean(0)',
	'RecurringPrice' => 'Boolean(1)',
	'Price' => 'Currency',
	'UniquePrice' => 'Currency',
	'ActivationPrice' => 'Currency',
	'UniquePriceLabel' => 'Varchar',
	'ActivationPriceLabel' => 'Varchar',
	'Unit' => 'Varchar',
	'FooterText' => 'HTMLText'
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('GroupID');
		$fields->dataFieldByName('Price')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('BestSeller')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('RecurringPrice')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('UniquePrice')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('ActivationPrice')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('UniquePriceLabel')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('ActivationPriceLabel')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('Unit')->hideIf('hasOptions')->isChecked();
		$fields->dataFieldByName('FooterText')->hideIf('hasOptions')->isChecked();

		if ($this->ID > 0){
			$fields->dataFieldByName('Options')->displayIf('hasOptions')->isChecked();
		}
		return $fields;
	}

	public function getCategoryTitle(){
		return $this->Category()->Title;
	}
	
}

