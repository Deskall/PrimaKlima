<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;


class ProductCategory extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(255)',
        'Description' => 'HTMLText',
        'URLSegment' => 'Varchar(255)'
    );


    private static $cascade_duplicates = ['Products'];

    private static $summary_fields = array(
        'Title' => 'Titel',
    );


    private static $has_one = array(
        'Image' =>  Image::class,
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
        $fields = parent::getCMSFields();
        $fields->fieldByName('Root.Main.Image')->setFolderName($this->getFolderName());


        return $fields;
    }

    public function getFolderName(){
        return 'Uploads/Webshop/'.$this->URLSegment;
    }

}


