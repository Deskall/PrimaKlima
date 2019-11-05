<?php

use SilverStripe\ORM\DataObject;


class ShopCart extends DataObject {

	
	private static $db = [
		'IP' => 'Varchar'
	];

	private static $has_one = [
		'Package' => Package::class
	];

	private static $many_many = [
		'Products' => Product::class
	];

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	}

	public function forTemplate(){
		return $this->renderWith('Includes/ShopCart');
	}

	public function TotalMonthlyPrice(){
		$price = 0;
		if ($this->Package()->exists()){
			$price += $this->Package->Price;
		}
		if ($this->Products()->exists()){
			foreach ($this->Products() as $product) {
				$price += $product->Price;
			}
		}
		return 'CHF '.number_format($price,2). ' /Mt.';
	}
}