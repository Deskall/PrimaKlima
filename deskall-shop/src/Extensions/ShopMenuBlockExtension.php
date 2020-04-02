<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class ShopMenuBlockExtension extends DataExtension{
	private static $block_types = [
		'Shop' => 'Webshop Menu'
	];

	public function CheckoutPage(){
	    return SiteConfig::current_site_config()->ShopPage();
	}

	public function activeCart(){
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		if ($id = $session->get('shopcart_id')){
		
		   $cart = ShopCart::get()->byId($id);
		   return $cart;
		}
		return null;
	}

}