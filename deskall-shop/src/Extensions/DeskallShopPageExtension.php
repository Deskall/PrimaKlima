<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class DeskallShopPageExtension extends DataExtension
{
    public function ShopPage(){
        return ShopPage::get()->first();
    }

    public function activeCart(){
    	$request = Injector::inst()->get(HTTPRequest::class);
    	$session = $request->getSession();
    	if ($session->get('shopcart_id') && ShopCart::get()->byId($session->get('shopcart_id'))){
    		$cart = ShopCart::get()->byId($session->get('shopcart_id'));
    	}
    	else{
    		$cart = new ShopCart();
    		$cart->IP = $request->getIp();
    		$cart->write();
    		$session->set('shopcart_id',$cart->ID);
    	}
    	
    	return $cart;
    }

}