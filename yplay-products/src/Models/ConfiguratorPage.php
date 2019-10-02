<?php

class ConfiguratorPage extends Page {
	private static $singular_name = "Abo Konfigurator";

	public function canCreate($member = null, $context = array()){
		return ConfiguratorPage::get()->count() == 0;
	}

	public function activeCategories(){
		return ProductCategory::get()->filter('isVisible',1);
	}
}