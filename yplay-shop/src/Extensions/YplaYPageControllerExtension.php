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
    private static $allowed_actions = ['SavePLZ', 'ClearPLZ'];

    private static $url_handlers = [
        'plz-speichern' => 'SavePLZ',
        'plz-loeschen' => 'ClearPLZ'
    ];

    public function onBeforeInit(){
      //If Subsite we check the PLZ
      $SubsiteID = SubsiteState::singleton()->getSubsiteId();
      ob_start();
            print_r($SubsiteID);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
      if ($SubsiteID > 0){
        //If PLZ we save it in session
        $PLZ = PostalCode::get()->filter('SubsiteID',$SubsiteID)->first();
        if ($PLZ) {
          $this->owner->getRequest()->getSession()->set('active_plz',$PostalCode->ID);
          $this->owner->getRequest()->getSession()->set('active_offer',$PostalCode->StandardOffer);
          Cookie::set('yplay_plz', $PostalCode->ID);
        }
      }
    }

    public function SavePLZ(HTTPRequest $request){
        $this->owner->getRequest()->getSession()->clear('active_plz');
        //clear also cart
        if ($this->activeCart()){
          $this->activeCart()->delete();
        }
        
        $this->owner->getRequest()->getSession()->clear('shopcart_id');
        
        $plz = $request->postVar('plz-choice');
        if ($plz){
          $this->owner->getRequest()->getSession()->clear('active_plz');
            $PostalCode = PostalCode::get()->filter('Code',$plz)->first();
            if ($PostalCode){ 
                //if externe we redirect
                //if subsite we redirect
                if ($PostalCode->SubsiteID > 0 || $PostalCode->Externe ){
                    return $this->owner->redirect($PostalCode->Link());
                }
                $this->owner->getRequest()->getSession()->set('active_plz',$PostalCode->ID);
                $this->owner->getRequest()->getSession()->set('active_offer',$PostalCode->StandardOffer);
                Cookie::set('yplay_plz', $PostalCode->ID);


                //In case no PLZ defined yet and customer has chosen a package or a product, we redirect to Configurator and save this chosen Product. 
                //for that we create cart and apply chosen element
                if ($this->owner->getRequest()->getSession()->get('chosen_package') || $this->owner->getRequest()->getSession()->get('chosen_product')){
                  $cart = new ShopCart();
                  $cart->IP = $this->owner->getRequest()->getIp();
                  $cart->PostalCode = $PostalCode->Code;
                  $cart->City = $PostalCode->City;
                  $cart->write();
                  $this->owner->getRequest()->getSession()->set('shopcart_id',$cart->ID);
                  if ($this->owner->getRequest()->getSession()->get('chosen_package')){
                    $package = Package::get()->byId($this->owner->getRequest()->getSession()->get('chosen_package'));
                    if ($package){
                      //If available
                      if (in_array($package->Availability, ["Immer",$PostalCode->StandardOffer,$PostalCode->AlternateOffer])){
                         //apply package
                          $cart->PackageID = $package->ID;
                          $cart->Availability = $cart->Package()->Availability;
                          $cart->write();
                          $this->owner->getRequest()->getSession()->set('active_offer',$cart->Availability);
                      }
                    }
                  }
                  else if ($this->owner->getRequest()->getSession()->get('chosen_product')){
                    $product = Product::get()->byId($this->owner->getRequest()->getSession()->get('chosen_product'));
                    if ($product){
                      //If not available we take the fallback
                      if (!in_array($product->Availability, ["Immer",$PostalCode->StandardOffer,$PostalCode->AlternateOffer])){
                        $product = $product->Category()->getPreselected();
                      }
                      
                       $cart->Products()->add($product);
                       $cart->Availability = $product->Availability;
                       $cart->write();
                       $this->owner->getRequest()->getSession()->set('active_offer',$cart->Availability);
                      
                    }
                  }
                }

                return $this->owner->redirectBack();
            }
            else{
                //return to unbekannt plz page
                $this->owner->getRequest()->getSession()->set('message','Unbekannte Region « '.$plz.' »');
               return $this->owner->redirectBack();
            }
        }
        //should not happen as plz is mandatory, but redirecting anyway
        return $this->owner->redirectBack();
    }

    public function ClearPLZ(HTTPRequest $request){
        Cookie::force_expiry('yplay_plz');
        $request->getSession()->clear('active_plz');
        //clear also cart
        if ($this->activeCart()){
           $this->activeCart()->delete();
        }
        $request->getSession()->clear('shopcart_id');
        return $this->owner->redirectBack();
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
       if($this->owner->ClassName == "ConfiguratorPage"){
        return false;
       }
       if (!$this->owner->getRequest()->getSession()->get('active_plz_asked')){
         $this->owner->getRequest()->getSession()->set('active_plz_asked',true);
         return true;
       } 
       return false;
    }


    public function filteredOptions(){
       $options = ProductOption::get()->filter(['GroupID' => 0, 'isVisible' => 1])->filterByCallback(function($item, $list) {
            if ($this->owner->activeCart()){
              return ($item->shouldDisplay() && $this->owner->activeCart()->hasCategory($item->Category()->Code) );
            }
            return $item->shouldDisplay();
       })->sort('CategorySort');
       
       return GroupedList::create($options);
    }

    public function activeCart(){
       $id = $this->owner->getRequest()->getSession()->get('shopcart_id');
       if ($id){
          $cart = ShopCart::get()->byId($id);
          if ($cart){
            if (!$cart->PostalCode && $this->owner->activePLZ()){
              $cart->PostalCode = $this->owner->activePLZ()->Code;
              $cart->City = $this->owner->activePLZ()->City;
            }
            $cart->write();
            return $cart;
          }
       }
       return null;
    }

    public function activeOffer(){
      if ($this->owner->getRequest()->getSession()->get('active_offer')){
        return $this->owner->getRequest()->getSession()->get('active_offer');
      }
      if ($this->owner->activeCart()){
        return $this->owner->activeCart()->Availability;
      }
      if ($this->owner->activePLZ()){
        return $this->owner->activePLZ()->StandardOffer;
      }
      return  "Fiber";
    }

    public function alternativePackages(){
      $activeOffer = $this->owner->getRequest()->getSession()->get('active_offer');
     
      if ($this->owner->activePLZ()){
        $availability = ($this->owner->activePLZ()->AlternateOffer == $activeOffer) ? $this->owner->activePLZ()->StandardOffer : $this->owner->activePLZ()->AlternateOffer;
      }
      else{
       
        $availability = ($activeOffer == "Cable") ? "Fiber" : "Cable";
      }
    
      return Package::get()->filter(['isVisible' => 1, 'Availability' => ['Immer',$availability]])->filterByCallback(function($item, $list) {
          return ($item->shouldDisplay());
      });;
    }

    public function alternativeProducts(){
      $activeOffer = $this->owner->getRequest()->getSession()->get('active_offer');
      if ($this->owner->activePLZ()){
        $availability = ($this->owner->activePLZ()->AlternateOffer == $activeOffer) ? $this->owner->activePLZ()->StandardOffer : $this->owner->activePLZ()->AlternateOffer;
      }
      else{
        $availability = ($activeOffer == "Cable") ? "Fiber" : "Cable";
      }
    
      return Product::get()->filter(['isVisible' => 1, 'Availability' => [$availability]])->filterByCallback(function($item, $list) {
          return ($item->shouldDisplay());
      });;
    }

    public function chosenItem(){
      if ($this->owner->getRequest()->getSession()->get('chosen_package')){
        return Package::get()->byId($this->owner->getRequest()->getSession()->get('chosen_package'));
      }
      if ($this->owner->getRequest()->getSession()->get('chosen_product')){
        return Product::get()->byId($this->owner->getRequest()->getSession()->get('chosen_product'));
      }
      return null;
    }
}