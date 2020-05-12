<?php

namespace Bak\Products;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;

class NewsPage extends Page {

    private static $has_one = array(
        'Category' => 'NewsCategory'
    );

    public function getCMSFields(){
         $fields = parent::getCMSFields();
         $categories = DataObject::get("NewsCategory")->sort(array('Categories.Title'=>'ASC'));
         $categoriesField = DropdownField::create('CategoryID', 'Kategorie', $source = $categories->map("ID", "Title"))->setEmptyString('Alle Kategorien');
         $fields->addFieldToTab('Root.Main', $categoriesField, 'ContentImage');

         return $fields;
    }
}

  

