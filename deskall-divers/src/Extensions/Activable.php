<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class Activable extends DataExtension
{

    private static $db = [
        'isVisible' => 'Boolean(1)'
    ];

    private static $defaults = [
        'isVisible' => 1
    ];

    
    public function updateFieldLabels(&$labels){
        $labels['isVisible'] = 'ist sichtbar?';
        
    }

    public function updateCMSFields(FieldList $fields){
    	// $fields->removeByName('isVisible');
    }

    public function show(){
    	$this->owner->isVisible = 1;
    	$this->owner->write();
    }

    public function hide(){
    	$this->owner->isVisible = 0;
    	$this->owner->write();
    }


    public function canActivate(){
        return true;
    }

    public function canDesactivate(){
        return true;
    }
}