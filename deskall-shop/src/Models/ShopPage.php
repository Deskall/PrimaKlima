<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class ShopPage extends Page {

	public function activeCart(){
		$id = $this->getRequest()->getSession()->get('shopcart_id');
		if ($id){
		   $cart = ShopCart::get()->byId($id);
		   return $cart;
		}
		return null;
	}

}