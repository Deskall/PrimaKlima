<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;

class ListItem extends DataObject
{

    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText',
        'URL' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Parent' => ListBlock::class,
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
        'ItemTitle' ,
        'ImageThumbnail' ,
        'getSummary'
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['ItemTitle'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['ImageThumbnail'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['getSummary'] = _t(__CLASS__.'.Summary',  'Inhalt');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
       
        return $fields;
    }

    public function ItemTitle(){
        $o = new DBHTMLText();
        $o->setValue($this->Title);
        return $o;
    }

    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? (($this->Image()->getExtension() == "svg" ) ? '<img src="'.$this->Image()->URL.'" width="250" height="200" />' : '<img src="'.$this->Image()->Fill(250,200)->URL.'" />') : _t(__CLASS__.'.NoBild','(keine)');
        $o->setValue($html);
        return $o;
    }

    public function getFolderName(){
        return $this->Parent()->getFolderName();
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    public function getPage(){
        return $this->Parent()->getPage();
    }


/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        return $entities;
    }

/************* END TRANLSATIONS *******************/

}
