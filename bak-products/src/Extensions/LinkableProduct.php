<?php
namespace Bak\Products;

use SilverStripe\ORM\DataExtension;
use Bak\Products\Models\Product;

class LinkableProduct extends DataExtension {

	public function updateLinkForm($form){
		$fields = $form->Fields();
		$linkType = $fields->dataFieldByName('LinkType');
		$source = $linkType->getSource();
		$source['Product'] = "Produktseite";
		$linkType->setSource($source);
		$products = Product::get()->sort('Name','ASC');
		$sourceProductList = array();
		foreach($products as $product){
			$sourceProductList['[product_link,id='.$product->ID.']'] = $product->Name;
		}
		$productlist = DropdownField::create('ProductID', "Produkt", $sourceProductList);
		$fields->insertAfter($productlist,'email');
		$form->setFields($fields);
		return $form;
	}
}