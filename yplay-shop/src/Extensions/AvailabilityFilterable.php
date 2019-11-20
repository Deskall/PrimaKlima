
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

    public function updateFieldLabels(&$labels){
        $labels['Availability'] = 'Verfügbarkeit';
    }

    public function updateCMSFields(FieldList $fields){
       $fields->removeByName('Availability');
       $fields->insertBefore('Title',DropdownField::create('Availability',$this->owner->fieldLabels()['Availability'],['all' => 'Beide', 'Fiber' => 'Fiber', 'Cable' => 'Cable']));
    }

    public function isAvailable(){
    	if ($this->owner->Availability == "all"){
    		return true;
    	}
    	$plz = $this->owner->getRequest()->getSession()->get('active_plz');
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