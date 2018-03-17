<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class Sortable extends DataExtension
{

    private static $db = [
        'Sort' => 'Int'
    ];

    private static $default_sort = ['Sort'];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('Sort');
    }

}