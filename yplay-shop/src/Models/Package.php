<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;

class Package extends DataObject {

	private static $db = [
	'ProductCode' => 'Varchar',
	'Title' => 'Varchar',
	'RecurringPrice' => 'Boolean(1)',
	'Price' => 'Currency',
	'UniquePrice' => 'Currency',
	'ActivationPrice' => 'Currency',
	'UniquePriceLabel' => 'Varchar',
	'ActivationPriceLabel' => 'Varchar',
	'Subtitle' => 'Text'
	];

	private static $has_one = [
		'Image' => Image::class
	];

	private static $many_many = [
		'Products' => Product::class
	];
	

	private static $extensions = [
		'Sortable',
		'Activable',
		'PLZFilterable',
		'Itemable'
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

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = 'Name';
		$labels['Subtitle'] = 'Untertitel';
		$labels['UniquePrice'] = 'Einmaliger Preis';
		$labels['UniquePriceLabel'] = 'Einmaliger Preis Erklärung';
		$labels['ActivationPrice'] = 'Grundgebühr';
		$labels['ActivationPriceLabel'] = 'Grundgebühr Preis Erklärung';
		$labels['Price'] = 'Preis';
		$labels['RecurringPrice'] = 'Monatlicher Preis?';
		$labels['PrintPriceString'] = 'Preis';

		return $labels;
	}

	public function PrintPriceString(){
		if ($this->RecurringPrice){
			return DBText::create()->setValue('CHF '.$this->Price.' / Mt.');
		}
		else{
			return DBText::create()->setValue('CHF '.$this->Price);
		}
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ProductCode');

		$fields->fieldByName('Root.Main.UniquePriceLabel')->displayIf('RecurringPrice')->isChecked();
		return $fields;
	}
}