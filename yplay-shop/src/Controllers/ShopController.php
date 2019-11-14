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

   private static $allowed_actions = ['fetchPackages', 'fetchCart', 'updateCartOptions', 'OrderLink', 'getActiveCart']; 

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

   public function getActiveCart(){
      $products = [];
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if ($cart){
         if ($cart->Package()->exists()){
            foreach ($cart->Package()->Products() as $p) {
              $products[$p->Category()->Code][] = $p->ProductCode; 
            }
         }
         if ($cart->Products()->exists()){
            foreach ($cart->Products() as $p) {
              $products[$p->Category()->Code][] = $p->ProductCode; 
            }
         }
      }
      
      return json_encode($products);
   }


   public function fetchCart(){
      // $this->getRequest()->getSession()->clear('shopcart_id');
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $products = $this->getRequest()->postVar('products');
      $packageID = $this->getRequest()->postVar('packageID');
     
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart && ($products || $packageID > 0)){
         $cart = new ShopCart();
         $cart->IP = $this->getRequest()->getIp();
         $cart->write();
         $this->getRequest()->getSession()->set('shopcart_id',$cart->ID);
      }

      if ($cart && ($products || $packageID > 0)){
         //apply package and product
         $cart->PackageID = $packageID;
         $productIds = ($cart->Package()->exists()) ? $cart->Package()->Products()->column('ProductCode') : [];
         $cart->Products()->removeAll();
         if ($products){
            foreach ($products as $code) {
               if (!in_array($code,$productIds)){
                  $product = Product::get()->filter('ProductCode',$code)->first();
                  if ($product){
                     $cart->Products()->add($product);
                  }
               }
            }
         }
      }
      if ($cart){
         $cart->write();
         return $cart->forTemplate();
      }

      return null;
      
   }

   public function updateCartOptions(){
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $options = $this->getRequest()->postVar('options');
     
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }

      if ($cart && $options ){
         //apply options
         $cart->Options()->removeAll();
         if ($options){
            foreach ($options as $code) {
              
                  $option = ProductOption::get()->filter('ProductCode',$code)->first();
                  if ($option){
                     $cart->Options()->add($option);
                  }
               
            }
         }
      }
      if ($cart){
         $cart->write();
         return $cart->forTemplate();
      }

      return null;
      
   } 
   
}