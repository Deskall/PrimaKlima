<?php
use SilverStripe\ORM\DataObject;

class OrderItem extends DataObject {

    private static $singular_name = "Artikel";
    private static $plural_name = "Artikeln";

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Quantity' => 'Int',
        'Price' => 'Currency'
    );

    private static $has_one = array(
        'Order' => ShopOrder::class,
        'Product' => Product::class
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


    public function createFromProduct($product){
        $this->ProductID = $product->ID;
        $this->Title = $product->Title;
        $this->Price = $product->Price;
        $this->Quantity = $product->Quantity;
        $this->Sort = $p->SortOrder;
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

