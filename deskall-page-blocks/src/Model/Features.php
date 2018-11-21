<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Features extends DataObject
{

    private static $db = [
        'Text' => 'Varchar'
    ];

    private static $has_one = [
        'Parent' => FeaturesBlock::class,
    ];

    private static $extensions = [
     'Sortable',
     'Activable'
    ];

    private static $summary_fields = [
        'Text' => 'Text'
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        return $fields;
    }
}
