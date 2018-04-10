<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class Collapsable extends DataExtension
{

    private static $db = [
        'collapsed' => 'Boolean(0)'
    ];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('collapsed');
    }

    public function collapse(){
    	$this->owner->collapsed = 1;
    	$this->owner->write();
    }

    public function expand(){
    	$this->owner->collapsed = 0;
    	$this->owner->write();
    }

}