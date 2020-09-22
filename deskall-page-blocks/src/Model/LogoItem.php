<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\FieldType\DBHTMLText;

class LogoItem extends DataObject
{

    private static $db = [
        'Title' => 'Text'
    ];

    private static $has_one = [
        'Parent' => GalleryBlock::class,
        'Image' => Image::class
    ];

    private static $extensions = [
        Versioned::class,
        'Activable',
        'Linkable',
        'Sortable'
    ];


    private static $owns = [
        'Image',
    ];


    private static $summary_fields = [
        'Title' ,
        'ImageThumbnail' 
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['ImageThumbnail'] = _t(__CLASS__.'.Image', 'Bild');
  

        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
       

        return $fields;
    }


    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? (($this->Image()->getExtension() == "svg" ) ? '<img src="'.$this->Image()->URL.'" width="150" height="100" />' : '<img src="'.$this->Image()->ScaleWidth(150)->URL.'" />') : _t(__CLASS__.'.NoBild','(keine)');
        $o->setValue($html);
        return $o;
    }

    public function getFolderName(){
        if ($this->ParentID > 0){
            return $this->Parent()->getFolderName();
        }
        if ($this->FooterBlockID > 0){
            return SiteConfig::current_site_config()->getFolderName();
        }
    }

}
