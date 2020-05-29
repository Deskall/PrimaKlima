<?php

namespace Bak\News;

use Page;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataObject;
use Bak\News\Models\NewsCategory;
use Bak\News\Models\News;
use Bak\News\Controllers\NewsPageController;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\AssetAdmin\Forms\UploadField;

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
        $fields->insertAfter('MenuTitle',HTMLEditorField::create('Lead',$this->fieldLabels()['Lead'])->setRows(3));
         $fields->insertAfter('Lead',HTMLEditorField::create('Content',$this->fieldLabels()['Content']));
        $fields->insertAfter('Content',UploadField::create('Image',$this->fieldLabels()['Lead'])->setFolderName($this->generateFolderName()));
        return $fields;
    }
}

  

