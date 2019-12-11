<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ShopPage extends Page {

	public function getProductConfig(){
		return ProductConfig::get()->first();
	}

	public function activePackages(){
		return Package::get()->filter('isVisible',1);
	}

}