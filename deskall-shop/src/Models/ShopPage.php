<?php


use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ListboxField;

class ShopPage extends Page {

	private static $db = ['Goods' => 'Varchar(255)'];

	private static $many_many= ['Products' => Product::class,'Packages' => Package::class];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removebyName('Goods');
		$fields->addFieldToTab('Root.Goods',DropdownField::create('Goods','Typ',['package' => 'Pakete', 'product' => 'Produkte']));
		$fields->addFieldToTab('Root.Goods',ListboxField::create('Products','Produkte',Product::get()->map('ID','Title'),$this->Products())->displayIf('Goods')->isEqualTo('product')->end());
		$fields->addFieldToTab('Root.Goods',ListboxField::create('Packages','Pakete',Package::get()->map('ID','Title'),$this->Packages())->displayIf('Goods')->isEqualTo('package')->end());
		return $fields;
	}

	public function getProductConfig(){
		return ProductConfig::get()->first();
	}

	public function activePackages(){
		return Package::get()->filter('isVisible',1);
	}

	public function activeParameters(){
	    return PackageConfigItem::get()->filter('isVisible',1);
	}

}