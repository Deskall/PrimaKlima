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
    $fields->removeByName('ProductID');
    $products = Product::get()->sort('Name');
    $fields->addFieldToTab('Root.Main', 
      $product = DropdownField::create('ProductID','Produkt',$products->map('ID','Name'))
      ->setEmptyString('Bitte wählen Sie ein Produkt aus.'));
    
    $product->displayIf('Type')->isEqualTo('Product');
  }
  
}