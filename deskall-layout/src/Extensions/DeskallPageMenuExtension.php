<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;
use SilverStripe\Control\Director;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Subsites\Extensions\SiteTreeSubsites;
use SilverStripe\Subsites\Extensions\FileSubsites;
use SilverStripe\Subsites\Model\Subsite;

class DeskallPageMenuExtension extends DataExtension
{
     private static $db = [
        'SubMenu' => 'Varchar(255)'
    ];

    private static $has_one = [];

    private static $has_many = ['Links' => SubMenuLink::class];

    public function updateCMSFields(FieldList $fields){
        $fields->addFieldToTab('Root.Main',DropdownField::create('SubMenu','Unten Navigation',['sub' => 'Seiten Struktur','custom' => 'Custom']));
    }





      /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('menu_level') as $key => $value) {
          $entities[__CLASS__.".menu_level_{$key}"] = $value;
        }

        return $entities;
    }

    /************* END TRANLSATIONS *******************/
}