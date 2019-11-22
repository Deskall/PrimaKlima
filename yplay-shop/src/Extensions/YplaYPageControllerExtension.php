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

    public function SavePLZ(HTTPRequest $request){
        $this->owner->getRequest()->getSession()->clear('active_plz');
        
        $plz = $request->postVar('plz-choice');
        if ($plz){
            $PostalCode = PostalCode::get()->filter('Code',$plz)->first();
            if ($PostalCode){ 
                //if externe we redirect
                //if subsite we redirect
                if ($PostalCode->SubsiteID > 0 || $PostalCode->Externe ){
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

    public function ClearPLZ(HTTPRequest $request){
        $this->owner->getRequest()->getSession()->clear('active_plz');
        Cookie::force_expiry('yplay_plz');
        //clear also cart
        $this->activeCart()->delete();
        $this->owner->getRequest()->getSession()->clear('shopcart_id');
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
       $options = ProductOption::get()->filter('GroupID',0)->filterByCallback(function($item, $list) {
           return ($item->shouldDisplay() && $this->owner->activeCart()->hasCategory($item->Category()->Code) );
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

    public function alternativePackages(){
      $activeOffer = $this->owner->getRequest()->getSession()->get('active_offer');
      print_r($activeOffer);
      if ($this->owner->activePLZ()){
        $availability = ($this->owner->activePLZ()->AlternateOffer == $activeOffer) ? $this->owner->activePLZ()->StandardOffer : $this->owner->activePLZ()->AlternateOffer;
      }
      else{
        print_r('ici');
        $availability = ($activeOffer == "Cable") ? "Fiber" : "Cable";
      }
      print_r($availability);
    
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

    
}