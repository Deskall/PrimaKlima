<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ShopPage extends Page {
	
	public function activeCategories(){
	    return ProductCategory::get()->filter('isVisible',1);
	}

}