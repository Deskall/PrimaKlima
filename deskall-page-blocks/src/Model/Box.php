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
        'Effect' => 'Varchar(255)',
        'EffectOptions' => 'Varchar(255)',
    ];

    private static $has_one = [
        'Parent' => BoxBlock::class,
        'Image' => Image::class,
        'Gallery' => GalleryBlock::class
    ];

    private static $extensions = [
        Versioned::class,
        'Activable',
        'Linkable',
        'Sortable'
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
        $fields->removeByName('GalleryID');
        $fields->FieldByName('Root.Main.Content')->setRows(3);
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.Settings',DropdownField::create('Effect',_t(__CLASS__.'.Effect','Effekt'), $this->getTranslatedSourceFor(__CLASS__,'effects')));
        $fields->addFieldToTab('Root.Settings',TextField::create('EffectOptions',_t(__CLASS__.'.EffectOptions','Effekt Optionen')));
        $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.Main','Inhalt'));
        $fields->FieldByName('Root.Settings')->setTitle(_t(__CLASS__.'.Settings','Einstellungen'));
        return $fields;
    }

    public function BoxTitle(){
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
        if ($this->Parent()->exists()){
            return $this->Parent()->getFolderName();
        }
        if ($this->Gallery()->exists()){
            return $this->Gallery()->getFolderName();
        }
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    public function getPage(){
        return $this->Parent()->getPage();
    }

    public function onAfterPublish(){
        if ($this->Parent()){
            $this->Parent()->publishSingle();
        }
        if ($this->getPage()){
             $this->getPage()->publishSingle();
        }
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
