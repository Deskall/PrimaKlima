<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;

class Box extends DataObject
{

    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText',
        'Sort' => 'Int',
        'Effect' => 'Varchar(255)',
        'EffectOptions' => 'Varchar(255)',
        'CallToAction' => 'Text'
    ];

    private static $has_one = [
        'Parent' => BoxBlock::class,
        'Image' => Image::class,
        'RelatedPage' => SiteTree::class
    ];

    private static $extensions = [
        Versioned::class
    ];

    private static $effects = [
        'none' => 'kein',
        'kenburns' => 'ken burns',
        'parallax' => 'parallax'
    ];


    private static $owns = [
        'Image',
    ];

    private static $summary_fields = [
        'BoxTitle' => 'Titel',
        'ImageThumbnail' => 'Bild'
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->removeByName('Sort');
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.Settings',DropdownField::create('Effect','Effect', self::$effects));
        $fields->addFieldToTab('Root.Settings',TextField::create('EffectOptions','Effect Optionen'));
        return $fields;
    }

    public function BoxTitle(){
        $o = new DBHTMLText();
        $o->setValue($this->Title);
        return $o;
    }

    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? '<img src="'.$this->Image()->Fill(250,200)->URL.'" />' : '(keine)';
        $o->setValue($html);
        return $o;
    }

    public function getFolderName(){
        return $this->Parent()->getFolderName();
    }
}
