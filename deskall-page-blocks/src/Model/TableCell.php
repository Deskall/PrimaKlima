<?php

use SilverStripe\ORM\DataObject;

class TableCell extends DataObject
{
    private static $db = [
        'Value' => 'Text',
        'Sort' => 'Int'
    ];

    private static $has_one = [
        'Header' => TableHeader::class,
        'Row' => TableRow::class
    ];

    public function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Value'] = _t(__CLASS__.'.Value','Inhalt');
      
      

        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
           

        return $fields;
    }


}
