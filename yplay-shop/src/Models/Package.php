<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

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
		if ($this->ID > 0){
			$fields->dataFieldByName('Products')->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction());
			$source = ($this->Availability == "Immer") ? Product::get()->filter('ClassName',Product::class) : Product::get()->filter([
				'ClassName' => Product::class,
				'Availability' => ['Immer', $this->Availability]
			]);
			$fields->dataFieldByName('Products')->getConfig()->getComponentByType(GridFieldAddExistingAutocompleter::class)->setSearchList($source);
		}
		
		return $fields;
	}

	/* Calculate difference between the sum of all products prices and the Package price */
	public function PriceGain(){
		$altPrice = 0;
		$altPriceU = 0;
		foreach($this->Products() as $p){
			$altPrice += $p->getMonthlyPrice();
			$altPriceU += $p->getPriceUnique() + $p->getFees();
		}
		$gainM = ($altPrice > 0) ? number_format( (($this->getMonthlyPrice() / $altPrice) - 1) * 100, 0 ) : 0;
		$gainU = ($altPriceU > 0) ? number_format( ((($this->getPriceUnique() + $this->getFees())/ $altPriceU) - 1) * 100,0 ) : 0;
		return new ArrayData(['gainM' => $gainM, 'gainU' => $gainU]);
	}

	public function activeProducts(){
		return $this->Products()->filter('isVisible',1)->sort('Sort');
	}

}

