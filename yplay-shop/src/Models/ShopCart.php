<?php

use SilverStripe\ORM\DataObject;


class ShopCart extends DataObject {

	
	private static $db = [
		'IP' => 'Varchar',
		'TotalMonthlyPrice' => 'Varchar',
		'TotalUniquePrice' => 'Varchar'
	];

	private static $has_one = [
		'Package' => Package::class
	];

	private static $many_many = [
		'Products' => Product::class
	];

	
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
		$this->TotalUniquePrice = "CHF ".number_format($price,2);
	}

	public function hasCategory($code){
		$confirm = false;
		if ($this->Package()->exists()){
			foreach ($this->Package()->Products() as $p) {
				if ($p->Category()->Code == $code){
					$confirm = true;
					return false;
				}
			}
		}
		if ($this->Products()->exists() && !$confirm){
			foreach ($this->Products() as $p) {
				if ($p->Category()->Code == $code){
					$confirm = true;
					return false;
				}
			}
		}
		ob_start();
					print_r('ici');
					$result = ob_get_clean();
					file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
		return $confirm;
	}
}