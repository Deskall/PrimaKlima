<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class Sortable extends DataExtension
{

    private static $db = [
        'Sort' => 'Int'
    ];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('Sort');
    }

}