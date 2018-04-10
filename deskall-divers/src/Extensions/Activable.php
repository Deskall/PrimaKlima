<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class Activable extends DataExtension
{

    private static $db = [
        'isVisible' => 'Boolean(1)'
    ];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('isVisible');
    }

    public function show(){
    	$this->owner->isVisible = 1;
    	$this->owner->write();
    }

    public function hide(){
    	$this->owner->isVisible = 0;
    	$this->owner->write();
    }

}