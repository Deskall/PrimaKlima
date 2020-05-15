<?php

namespace Bak\News;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use Bak\News\Models\NewsCategory;
use Bak\News\Models\News;
use Bak\News\Controllers\NewsPageController;
use SilverStripe\Assets\Image;

class NewsPage extends Page {

    private static $table_name="BAK_NewsPage";

    // private static $can_be_root = false;

    private static $db = array(
        'Lead' => 'HTMLText',
    );

    private static $has_one = array(
        'Image' => Image::class
    );

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        // $fields->fieldByName('Root.Main.Lead')->setRows(3);
        // $fields->fieldByName('Root.Main.Image')->setFolderName($this->generateFolderName());
        return $fields;
    }

    public function getControllerName()
    {
        return NewsPageController::class;
    }
}

  

