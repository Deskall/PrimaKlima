<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Control\Cookie;

class Itemable extends DataExtension
{
    private static $many_many = [
        'Items' => ProductItem::class
    ];

    public function updateFieldLabels(&$labels){
        $labels['Items'] = 'Spezifikationen';
    }

    public function updateCMSFields(FieldList $fields){
       
    }

}