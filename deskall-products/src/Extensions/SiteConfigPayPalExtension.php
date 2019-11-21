<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;


class SiteConfigPayPalExtension extends DataExtension 
{

  private static $db = [
    'PayPalClientID' => 'Varchar',
    'PayPalSecret' => 'Varchar'
  ];

  public function updateFieldLabels(&$labels){
  	 $labels['PayPalClientID'] = _t(__CLASS__.'.PayPalClientID','PayPal Kunden ID');
     $labels['PayPalSecret'] = _t(__CLASS__.'.PayPalSecret','PayPal Kunden Secret');
  }

  public function updateCMSFields(FieldList $fields) {
     
    $fields->addFieldsToTab('Root.PayPal',[
      
      TextField::create('PayPalClientID'),
      TextField::create('PayPalSecret')
     
    ]);
   
  }

  
}