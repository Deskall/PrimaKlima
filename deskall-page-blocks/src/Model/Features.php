<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Features extends DataObject
{

    private static $db = [
        'Text' => 'HTMLText'
    ];

    private static $has_one = [
        'Parent' => FeaturesBlock::class,
    ];

    private static $extensions = [
     'Sortable',
     'Activable'
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->dataFieldByName('Text')->setRows(3);
        return $fields;
    }
}
