<?php


use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ListboxField;

class ShopPage extends Page {


	private static $has_many= ['Packages' => Package::class];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removebyName('Goods');
		$fields->addFieldToTab('Root.Goods',DropdownField::create('Goods','Typ',['package' => 'Pakete', 'product' => 'Produkte']));
		$fields->addFieldToTab('Root.Goods',ListboxField::create('Packages','Pakete',Package::get()->map('ID','Title'),$this->Packages()));
		return $fields;
	}

	public function getProductConfig(){
		return ProductConfig::get()->first();
	}

	public function activePackages(){
		return $this->Packages()->filter('isVisible',1);
	}


	public function activeParameters(){
	    return PackageConfigItem::get()->filter('isVisible',1);
	}

}