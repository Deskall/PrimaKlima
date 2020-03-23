<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;


class Product extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText'
    );


    private static $cascade_duplicates = ['Products'];

    private static $summary_fields = array(
        'Title' => 'Titel',
    );

    private static $has_many = array(
        'Products' =>  Product::class,
    );

    private static $singular_name = 'Kategorie';
    private static $plural_name = 'Kategorien';

    private static $extensions = [
        'Activable',
        'Sortable'
    ];



    public function getCMSFields() {
        $fields = new FieldList();



        return $fields;
    }

}


