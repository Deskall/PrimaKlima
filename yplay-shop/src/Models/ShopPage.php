<?php

class ShopPage extends Page {
	private static $singular_name = "Bestellung Seite";

	public function canCreate($member = null, $context = array()){
		return ShopPage::get()->count() == 0;
	}


}