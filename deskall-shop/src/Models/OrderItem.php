<?php
use SilverStripe\ORM\DataObject;

class OrderItem extends DataObject {

    private static $singular_name = "Artikel";
    private static $plural_name = "Artikeln";

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Quantity' => 'Int',
        'PriceUnique' => 'Currency',
        'Price' => 'Currency'
    );

    private static $has_one = array(
        'Order' => ShopOrder::class,
        'Cart' => ShopCart::class,
        'Product' => Product::class,
        'Variant' => ProductVariant::class
    );

    private static $extensions = ['Sortable'];

    private static $summary_fields = array(
        'Title' => 'Titel',
        'Price' => 'Preis',
        'Quantity' => 'Anzahl'
    );


    public function getTotalPrice(){
        return floatval($this->Price*$this->Quantity);
    }


    public function createFromProduct($product,$quantity){
        $this->ProductID = $product->ID;
        $this->Title = $product->Title;
        $this->PriceUnique = $product->Price;
        $this->Price = $product->Price * $quantity;
        $this->Quantity = $quantity;
        $this->Sort = $product->SortOrder;
        $this->write();
    }

    public function createFromVariant($variant,$quantity){
        $this->VariantID = $variant->ID;
        $this->Title = $variant->getFullTitle();
        $this->PriceUnique = $variant->Price;
        $this->Price = $variant->Price * $quantity;
        $this->Quantity = $quantity;
        $this->Sort = $variant->SortOrder;
        $this->write();
    }

 




    public function onBeforeWrite(){
        parent::onBeforeWrite();
    }

    public function onAfterWrite(){
        
       
        parent::onAfterWrite();
    }

    public function onAfterDelete(){
       
        parent::onAfterDelete();
    }



}

