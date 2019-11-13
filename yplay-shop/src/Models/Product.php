<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class Product extends DataObject {

	private static $singular_name = 'Produkt';
	private static $plural_name = 'Produkte';

	private static $db = [
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
	];

	private static $has_one = [
		'Category' => ProductCategory::class
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

	private static $searchable_fields = [
		'Title'
	];

	public function onBeforeWrite(){
	    if (!$this->ProductCode || $this->ID == 0){
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
		$labels['Unit'] = 'Einheit';
		$labels['RecurringPrice'] = 'Monatlicher Preis?';
		$labels['PrintPriceString'] = 'Preis';
		$labels['BestSeller'] = 'Bestseller?';
		$labels['FooterText'] = 'Weitere Informationen (wird im Produkt Kart zeigt an boden.)';

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
		$fields->removeByName('CategoryID');
		$fields->removeByName('FooterText');

		$fields->fieldByName('Root.Main.Unit')->displayIf('RecurringPrice')->isNotChecked();
		$fields->fieldByName('Root.Main.UniquePriceLabel')->displayIf('RecurringPrice')->isChecked();
		if ($this->ID > 0){
			$fields->addFieldToTab('Root.Items',HTMLEditorField::create('FooterText',$this->fieldLabels()['FooterText'])->setRows(3));
		}
		
		return $fields;
	}

	//To do: elaborate with Actions
	public function getMonthlyPrice(){
		return $this->Price;
	}

	public function getPriceUnique(){
		return $this->UniquePrice;
	}

	public function getFees(){
		return $this->ActivationPrice;
	}
}