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

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->saveCells();
    }

    public function saveCells(){
        $changed = $this->getChangedFields();
        ob_start();
            print_r($changed);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
           

        return $fields;
    }


}
