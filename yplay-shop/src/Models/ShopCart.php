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
}