<?php
use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Control\Cookie;
use SilverStripe\Control\Session;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\GroupedList;

class YplaYPageControllerExtension extends Extension
{   
    private static $allowed_actions = ['SavePLZ', 'OrderLink'];

    private static $url_handlers = [
        'plz-speichern' => 'SavePLZ',
        'paket-bestellen/$ID' => 'OrderLink' 
    ];

    public function SavePLZ(HTTPRequest $request){
        $this->owner->getRequest()->getSession()->clear('active_plz');
        
        $plz = $request->postVar('plz-choice');
        if ($plz){
            $PostalCode = PostalCode::get()->filter('Code',$plz)->first();
            if ($PostalCode){ 
                
                //if subsite we redirect
                if ($PostalCode->SubsiteID > 0){
                    return $this->owner->redirect($PostalCode->Link());
                }
                Cookie::set('yplay_plz', $PostalCode->ID);
                return $this->owner->redirectBack();
            }
            else{
                //return to unbekannt plz page
                return ['Title' => 'Unbekannt Region'];
            }
        }
        //should not happen as plz is mandatory, but redirecting anyway
        return $this->owner->redirectBack();
    }

     /* Update the Cart and link to Order Page */
    public function OrderLink(){
       //Fetch cart or create if null
      
       $id = $this->owner->getRequest()->getSession()->get('shopcart_id');
       $cart = null;
       if ($id){
          $cart = ShopCart::get()->byId($id);
       }
       if (!$cart){
          $cart = new ShopCart();  
       }
       $cart->IP = $this->owner->getRequest()->getIp();

       //fetch package and link it
       $packageID = $this->owner->getRequest()->param('ID');
       if ($packageID){
         $package = Package::get()->byId($packageID);
         if ($package){
            $cart->PackageID = $package->ID;
            $cart->Products()->removeAll();
         }
       }
       
       $cart->write();
       $this->owner->getRequest()->getSession()->set('shopcart_id',$cart->ID);
       return $this->owner->redirect($this->owner->ShopPage()->Link(),302);
    }

//--------- UTILITIES -----------//
    public function activePLZ(){
        //first we check if there is cookie
        $plz = Cookie::get('yplay_plz');
        // $plz = $this->owner->getRequest()->getSession()->get('active_plz');
        if ($plz){
            $PostalCode = PostalCode::get()->byId($plz);
            if ($PostalCode){
                if (!$this->owner->getRequest()->getSession()->get('active_plz')){
                   $this->owner->getRequest()->getSession()->set('active_plz',$PostalCode->ID); 
                }
                return $PostalCode;
            }
        }
        return null;
    }

    public function showModalPLZ(){
       if (!$this->owner->getRequest()->getSession()->get('active_plz_asked')){
         $this->owner->getRequest()->getSession()->set('active_plz_asked',true);
         return true;
       } 
       return false;
    }


    public function filteredOptions(){
       $options = ProductOption::get()->filter('GroupID',0)->filterByCallback(function($item, $list) {
           return ($item->shouldDisplay());
       })->sort('CategoryTitle');
       
       return GroupedList::create($options);
    }

    public function activeCart(){
       $id = $this->owner->getRequest()->getSession()->get('shopcart_id');
       if ($id){
          $cart = ShopCart::get()->byId($id);
          return $cart;
       }
       return null;
    }

    
}