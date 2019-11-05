<?php

use DNADesign\Elemental\Controllers\ElementController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\i18n\i18n;
use SilverStripe\Security\Member;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ArrayList;

class ShopController extends PageController
{

   private static $allowed_actions = ['fetchPackages', 'fetchCart']; 

   public function fetchPackages(){
   	$packages = Package::get()->filter('isVisible',1)->filterByCallback(function($item, $list) {
   		return ($item->shouldDisplay());
   	});
	  $array = [];
   	foreach ($packages as $package) {
   		$array[$package->ProductCode] = $package->toMap();
   		$products = [];
   		foreach($package->Products() as $product){
   			$products[] = $product->ProductCode;
   		}
   		$array[$package->ProductCode]['Products'] = $products;
   	}
   	return json_encode($array);
   }

   public function fetchCart(){
      // $this->getRequest()->getSession()->clear('shopcart_id');
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart){
         $cart = new ShopCart();
         $cart->IP = $this->getRequest()->getIp();
         $cart->write();
         $this->getRequest()->getSession()->set('shopcart_id',$cart->ID);
      }

      //apply package and product
      $cart->PackageID = $this->getRequest()->postVar('packageID');
      $productIds = ($cart->Package()->exists()) ? $cart->Package()->Products()->column('ProductCode') : [];
      $cart->Products()->removeAll();
      if ($products = $this->getRequest()->postVar('products')){
         foreach ($products as $code) {
            if (!in_array($code,$productIds)){
               $product = Product::get()->filter('ProductCode',$code)->first();
               if ($product){
                  $cart->Products()->add($product);
               }
            }
         }
      }

      $cart->write();
      return $cart->forTemplate();
   } 
}