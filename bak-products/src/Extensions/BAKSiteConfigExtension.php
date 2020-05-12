<?php 

namespace BAK\Products;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;

class BAKSiteConfigExtension extends DataExtension 
{

  private static $db = [
    
  ];

  private static $has_one = [
    'ConfirmationPage' => SiteTree::class
  ];

  public function updateCMSFields(FieldList $fields) {
     

    //ADDRESS
    $fields->addFieldsToTab('Root.Produkte',[
      TreeDropdownField::create('ConfirmationPageID','Produktformular Bestätigung Seite',SiteTree::class)
    ]);
    
  }

  
}