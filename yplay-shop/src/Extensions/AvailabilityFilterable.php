
<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Control\Cookie;
use SilverStripe\Forms\DropdownField;

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

    public function updateShouldDisplay($display){
       if ($display){
       		ob_start();
       				print_r($this->owner->ProductCode." ".$display);
       				$result = ob_get_clean();
       				file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);
	       	//if always available, we return display
	       	if ($this->owner->Availability == "all"){
	       		return $display;
	       	}
	       
	        //first we check if plz is defined
	        $plz = Cookie::get('yplay_plz');
	        if ($plz){
	             //then we check if plz exists
	            $PostalCode = PostalCode::get()->byId($plz);
	            if ($PostalCode){
	                $display = ($this->owner->Availability == $PostalCode->StandardOffer );
	            }
	        }
	        //else we apply fiber
	        else{
	        	 $display = ($this->owner->Availability == "Fiber");
	        }
    	}
    	
    }
}