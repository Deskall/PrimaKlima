<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\ArrayData;

class Package extends Product {
	private static $singular_name = 'Paket';
	private static $plural_name = 'Pakete';

	private static $db = [
	
	];

	private static $has_one = [
		'Image' => Image::class
	];

	private static $many_many = [
		'Products' => Product::class
	];
	
	private static $defaults = [
		'RecurringPrice' => 1
	];
	

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Products'] = 'Produkte';

		return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('RecurringPrice');
		$fields->removeByName('Unit');
		$fields->FieldByName('Root.Products.Products')->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction());
		
		return $fields;
	}

	public function PriceGain(){
		$altPrice = 0;
		$altPriceU = 0;
		foreach($this->Products() as $p){
			$altPrice += $p->Price;
			$altPriceU += $p->UniquePrice + $p->ActivationPrice;
		}
		$gainM = ($altPrice > 0) ? number_format( (($this->Price / $altPrice) - 1) * 100, 0 ) : 0;
		$gainU = ($altPriceU > 0) ? number_format( ((($this->Price + $this->ActivationPrice)/ $altPriceU) - 1) * 100,0 ) : 0;
		return new ArrayData(['gainM' => $gainM, 'gainU' => $gainU]);
	}
}

