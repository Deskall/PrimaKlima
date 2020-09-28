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
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Subsites\State\SubsiteState;

class ShopController extends PageController
{

   private static $allowed_actions = ['fetchPackages', 'fetchCart', 'updateCartOptions', 'getActiveCart', 'updateCartStep', 'updateCartData', 'updateCartAvailability', 'smartcard', 'checkCustomer', 'CheckPartnerForCode']; 

   public function fetchPackages(){
   	$packages = Package::get()->filter('isVisible',1)->filterByCallback(function($item, $list) {
   		return ($item->shouldDisplay() && $item->isAvailable() );
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

   public function getActiveCartObject(){
      $products = [];
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      return $cart;
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
      if (!$cart && ((is_array($products) && count($products) > 0) || $packageID > 0)){
         $cart = new ShopCart();
         $cart->IP = $this->getRequest()->getIp();
         $cart->SubsiteID = SubsiteState::singleton()->getSubsiteId();
         if ($this->activePLZ()){
            $cart->PostalCode = $this->activePLZ()->Code;
            $cart->City = $this->activePLZ()->City;
         }
         $cart->write();
         $this->getRequest()->getSession()->set('shopcart_id',$cart->ID);
      }

      if ($cart && ((is_array($products) && count($products) > 0) || $packageID > 0)){
         //apply package and product
         $cart->PackageID = $packageID;
         if ($cart->PackageID > 0){
            $cart->Availability = $cart->Package()->Availability;
         }
         $productIds = ($cart->Package()->exists()) ? $cart->Package()->Products()->column('ProductCode') : [];
         $cart->Products()->removeAll();
         if ($products){
            $i = 1;
            foreach ($products as $code ) {
               if (!in_array($code,$productIds)){
                  $product = Product::get()->filter('ProductCode',$code)->first();
                  if ($product){
                     $cart->Products()->add($product,['SortOrder' => $i, 'Quantity' => 1]);
                     $i++;
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

      if ($cart ){
         //apply options
         $cart->Options()->removeAll();
         if ($options){
            foreach ($options as $index => $value) {
              
                  $option = ProductOption::get()->filter('ProductCode',$value['code'])->first();
                  if ($option){
                     $cart->Options()->add($option, ['Quantity' => $value['quantity']]);
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

   public function smartcard(){
     
      $options = $this->getRequest()->postVar('options');
   
      if ($options){
         $id = $this->getRequest()->getSession()->get('shopcart_id');
         $cart = ($id) ? ( (ShopCart::get()->byId($id)) ? ShopCart::get()->byId($id) : new ShopCart() ) : new ShopCart() ;
         $cart->write();
         $i = 1;
         foreach ($options as $code => $quantity) {
            $option = ProductOption::get()->filter('ProductCode',$code)->first();
            if ($option){
               $cart->Options()->add($option, ['SortOrder' => $i,'Quantity' => $quantity]);
               $i++;
            }
         }
         $this->getRequest()->getSession()->set('shopcart_id',$cart->ID);
         return json_encode(['link' => ShopPage::get()->filter('SubsiteID',SubsiteState::singleton()->getSubsiteId())->first()->Link()]);
      }

     return json_encode(['error' => '']);
      
   } 

   public function updateCartStep(){
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $step = $this->getRequest()->postVar('step');
     
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }

      if ($cart && $step ){
         //apply options
         $cart->CurrentStep = $step;
          $cart->write();
      }

      return;
      
   } 

   public function updateCartData(){
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $form = $this->getRequest()->postVar('form');

      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }

      if ($cart && $form ){
         $data = array();
         parse_str($form, $data);
         $cart->update($data);
         $cart->write();
      }

      return;
      
   }

   public function updateCartAvailability(HTTPRequest $request){
      //retrieve cart in session
      $id = $request->getSession()->get('shopcart_id');
      $availability = $request->getVar('availability');

      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }

      if ($cart && $availability ){
         $cart->Availability = $availability;
         //We remove all attached Packages, Product and Options
         $cart->Products()->removeAll();
         $cart->Packages()->removeAll();
         $cart->Options()->removeAll();
         $cart->write();
         return json_encode(['message' => 'Warenkorb aktualisiert']);
      }

      return json_encode(['message' => 'Fehler']);
      
   }

   /* from checkout, if new Customer, we check rules to apply
   */
   public function checkCustomer(){
      $cart = $this->getActiveCartObject();
      $isCustomer = $this->getRequest()->postVar('isCustomer');
      if ($cart){
         $cart->ExistingCustomer = $isCustomer;
         $cart->write();
         //Rules for new customer
         if (!$isCustomer){
            if ($cart->hasPremiumSender() && !$cart->hasCategory('yplay-watch')){
               //TV Abo is required, redirection to configurator
               $tvCategory = ProductCategory::get()->filter('Code','yplay-watch')->first();
               $preselected = $tvCategory->getPreselected();
               return json_encode(['link' => $preselected->OrderLink()]);
            }
         }
         
      }

      return json_encode(['message' => 'nothing to do']);
   }

   public function CheckPartnerForCode(HTTPRequest $request){
       $code = trim($request->param('ID'));
       if ($code){
           $plz = PostalCode::get()->filter('Code',$code)->first();
           if ($plz){
               $shop = $plz->Shop();
               if ($shop->exists()){
                   return $shop->renderWith('Includes/ShopTemplate');
               }
               else{
                  $dslOffers = Product::get()->filter('Availability','DSL');
                  return $this->customise(['Offers' => $dslOffers])->renderWith('Includes/DSLOffers');
               }
               return DBHTMLText::create()->setValue('<p>Es gibt keine Partner für diese Region</p>');
           }
           return DBHTMLText::create()->setValue('<p>Unbekannte Region</p>');
       }
       return DBHTMLText::create()->setValue('<p>Unbekannte Region</p>');
   }
   
}