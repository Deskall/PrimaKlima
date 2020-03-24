<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ShopPage extends Page {


	public function activeProducts(){
		return Product::get()->filter('isVisible',1);
	}

	

}