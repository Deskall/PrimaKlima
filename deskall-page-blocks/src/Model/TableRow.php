<?php

use SilverStripe\ORM\DataObject;

class TableRow extends DataObject
{


    private static $has_one = [
        'Parent' => TableBlock::class
    ];

    private static $has_many = ['Cells' => TableCell::class];

    private static $owns = ['Cells'];

    private static $cascade_duplicates = ['Cells'];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];




    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
           

        return $fields;
    }


}
