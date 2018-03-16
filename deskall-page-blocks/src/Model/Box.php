<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;

class Box extends DataObject
{

    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText',
        'Sort' => 'Int',
        'Effect' => 'Varchar(255)',
        'EffectOptions' => 'Varchar(255)',
    ];

    private static $has_one = [
        'Parent' => BoxBlock::class,
        'Image' => Image::class
    ];

    private static $extensions = [
        Versioned::class,
        'Activable',
        'Linkable'
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
        'BoxTitle' ,
        'ImageThumbnail' ,
        'getSummary'
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['BoxTitle'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['ImageThumbnail'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['getSummary'] = _t(__CLASS__.'.Summary',  'Inhalt');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->removeByName('Sort');
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.Settings',DropdownField::create('Effect',_t(__CLASS__.'.Effect','Effekt'), $this->getTranslatedSourceFor(__CLASS__,'effects')));
        $fields->addFieldToTab('Root.Settings',TextField::create('EffectOptions',_t(__CLASS__.'.EffectOptions','Effekt Optionen')));
        return $fields;
    }

    public function BoxTitle(){
        $o = new DBHTMLText();
        $o->setValue($this->Title);
        return $o;
    }

    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? '<img src="'.$this->Image()->Fill(250,200)->URL.'" />' : _t(__CLASS__.'.NoBild','(keine)');
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


/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('effects') as $key => $value) {
          $entities[__CLASS__.".effects_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/

}
