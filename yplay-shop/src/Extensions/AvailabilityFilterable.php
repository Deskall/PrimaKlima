
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

    public function updateShouldDisplay($display){
       if ($display){
       		
	       	//if always available, we return display
	       	if ($this->owner->Availability == "all"){
	       		return $display;
	       	}
	       
	        //first we check if plz is defined
	        $request = Injector::inst()->get(HTTPRequest::class);
	        $session = $request->getSession();
	        $plz = $session->get('active_plz');
	        if ($plz){
	             //then we check if plz exists
	            $PostalCode = PostalCode::get()->byId($plz);
	            if ($PostalCode){
	            	ob_start();
	            			print_r($this->owner->ProductCode." ".$display."\n");
	            			print_r($this->owner->Availability." ".$PostalCode->StandardOffer."\n");
	            			$result = ob_get_clean();
	            			file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);
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