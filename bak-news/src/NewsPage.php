<?php

namespace Bak\News;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use Bak\News\Models\NewsCategory;
use Bak\News\Models\News;
use Bak\News\Controllers\NewsPageController;

class NewsPage extends Page {

    private static $table_name="BAK_NewsPage";

    private static $has_one = array(
        'Category' => NewsCategory::class
    );

    public function getCMSFields(){
         $fields = parent::getCMSFields();
         $categories = NewsCategory::get()->sort('Title');
         $categoriesField = DropdownField::create('CategoryID', 'Kategorie', $source = $categories->map("ID", "Title"))->setEmptyString('Alle Kategorien');
         $fields->addFieldToTab('Root.Main', $categoriesField, 'ContentImage');

         return $fields;
    }

    public function getControllerName()
    {
        return NewsPageController::class;
    }
}

  

