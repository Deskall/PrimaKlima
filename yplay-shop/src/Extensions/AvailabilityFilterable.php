<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Control\Cookie;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class AvailabilityFilterable extends DataExtension
{
    private static $db = ['Availability' => 'Varchar'];

    private static $defaults = ['Availability' => 'Immer'];

    public function updateFieldLabels(&$labels){
        $labels['Availability'] = 'Verfügbarkeit';
    }

    public function updateCMSFields(FieldList $fields){
       $fields->removeByName('Availability');
       $fields->insertBefore('Title',DropdownField::create('Availability',$this->owner->fieldLabels()['Availability'],['Immer' => 'Immer', 'Fiber' => 'Fiber', 'Cable' => 'Cable','DSL' => 'DSL']));
    }

    public function isAvailable(){
    	if ($this->owner->Availability == "Immer"){
    		return true;
    	}
    	$request = Injector::inst()->get(HTTPRequest::class);
    	$session = $request->getSession();
        //First we check if cart availability is defined
        $id = $session->get('shopcart_id');
        $cart = null;
        if ($id){
           $cart = ShopCart::get()->byId($id);
        }
        if ($cart && $cart->Availability ){
            return ($this->owner->Availability == $cart->Availability );
        }
        else{
           $plz = $session->get('active_plz');
            if ($plz){
                 //then we check if plz exists
                $PostalCode = PostalCode::get()->byId($plz);
                if ($PostalCode){
                    return ($this->owner->Availability == $PostalCode->StandardOffer );
                }
            }
            //else we return fiber
            return ($this->owner->Availability == "Fiber" ); 
        }
    	
    }
}