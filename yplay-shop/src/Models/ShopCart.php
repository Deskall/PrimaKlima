<?php

use SilverStripe\ORM\DataObject;


class ShopCart extends DataObject {

	
	private static $db = [
		'IP' => 'Varchar',
		'TotalMonthlyPrice' => 'Varchar',
		'TotalUniquePrice' => 'Varchar',
		'Purchased' => 'Boolean(0)',
		'CurrentStep' => 'Varchar'
	];

	private static $has_one = [
		'Order' => ShopOrder::class,
		'Package' => Package::class,
		'Customer' => ShopCustomer::class
	];

	private static $many_many = [
		'Products' => Product::class,
		'Options' => ProductOption::class
	];

	private static $many_many_extraFields = [
		'Products' => ['SortOrder' => 'Int']
	]

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->writeTotalMonthlyPrice();
		$this->writeTotalUniquePrice();
	}

	public function forTemplate(){
		return $this->renderWith('Includes/ShopCart');
	}

	public function writeTotalMonthlyPrice(){
		$price = 0;
		if ($this->Package()->exists()){
			$price += $this->Package->Price;
		}
		if ($this->Products()->exists()){
			foreach ($this->Products() as $product) {
				$price += $product->Price;
			}
		}
		if ($this->Options()->exists()){
			foreach ($this->Options() as $product) {
				$price += $product->Price;
			}
		}
		$this->TotalMonthlyPrice = "CHF ".number_format($price,2)." /Mt.";
	}

	public function writeTotalUniquePrice(){
		$price = 0;
		if ($this->Package()->exists()){
			$price += $this->Package->UniquePrice;
			$price += $this->Package->ActivationPrice;
		}
		if ($this->Products()->exists()){
			foreach ($this->Products() as $product) {
				$price += $product->UniquePrice;
				$price += $product->ActivationPrice;
			}
		}
		if ($this->Options()->exists()){
			foreach ($this->Options() as $product) {
				$price += $product->UniquePrice;
				$price += $product->ActivationPrice;
			}
		}

		$this->TotalUniquePrice = "CHF ".number_format($price,2);
	}

	public function hasCategory($code){
		$confirm = false;
		if ($this->Package()->exists()){
			foreach ($this->Package()->Products() as $p) {
				if ($p->Category()->Code == $code){
					$confirm = true;
					break;
				}
			}
		}
		if ($this->Products()->exists() && !$confirm){
			foreach ($this->Products() as $p) {
				if ($p->Category()->Code == $code){
					$confirm = true;
					break;
				}
			}
		}
		return $confirm;
	}

	public function isEmpty(){
		return (!$this->Package()->exists() && !$this->Products()->exists());
	}
}