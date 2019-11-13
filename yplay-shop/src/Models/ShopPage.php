<?php

class ShopPage extends Page {
	private static $singular_name = "Bestellung Seite";

	public function canCreate($member = null, $context = array()){
		return ShopPage::get()->count() == 0;
	}

	public function filteredOptions(){
		$options = ProductOption::get()->filterByCallback(function($item, $list) {
		    return ($item->shouldDisplay());
		});
		
		return $options;
	}

	public function activeCart(){
		$id = $this->getRequest()->getSession()->get('shopcart_id');
		if ($id){
			$cart = ShopCart::get()->byId($id);
			return $cart;
		}
		return null;
	}

}