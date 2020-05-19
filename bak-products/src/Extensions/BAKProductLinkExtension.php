<?php 

namespace BAK\Products;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use BAK\Products\Models\Product;
use SilverStripe\Forms\DropdownField;

class BAKProductLinkExtension extends DataExtension {

  private static $types = [
    "Product"
  ];

  private static $has_one = [
    "Product" => Product::class
  ];

  public function updateCMSFields(FieldList $fields) {
    $products = Product::get()->sort('Name');
    $fields->addFieldToTab('Root.Main', 
      DropdownField::create('Product','Produkt',$products->map('ID','Name'))
      ->setEmptyString('Bitte wählen Sie ein Produkt aus.'));
      // ->->end());
    $fields->dataFieldByName('Root.Main.Product')->displayIf('Type')->isEqualTo('Product');
  }
  
}