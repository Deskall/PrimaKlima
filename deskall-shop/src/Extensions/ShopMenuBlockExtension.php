<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;


class ShopMenuBlockExtension extends DataExtension{
	private static $block_types = [
		'Shop' => 'Webshop Menu'
	];

	public function CheckoutPage(){
	    return SiteConfig::current_site_config()->ShopPage();
	}

}