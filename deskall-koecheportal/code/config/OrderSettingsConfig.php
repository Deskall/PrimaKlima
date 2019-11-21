<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;

class OrderSettingsConfig extends DataExtension {     

   public static $db = array(     
    'OrderNumberOffset' => 'Int',
    'ClientNumberOffset' => 'Int',
    );

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab("Root.Bestllungen", new NumericField("OrderNumberOffset", "OrderNumberOffset"));  
        $fields->addFieldToTab("Root.Bestllungen", new NumericField("ClientNumberOffset", "ClientNumberOffset")); 

    }
}