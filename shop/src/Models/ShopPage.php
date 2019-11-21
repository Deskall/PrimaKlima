<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ShopPage extends Page {

	public function getProductConfig(){
		return ProductConfig::get()->first();
	}

	public function activeProducts(){
		return Product::get()->filter('isVisible',1);
	}

	public function activeCategories(){
		return ProductCategory::get()->filter(['isVisible' => 1,'ParentID' => 0]);
	}

	public function MainShopPage(){
		return ShopPage::get()->filter('URLSegment','shop')->first();
	}
}