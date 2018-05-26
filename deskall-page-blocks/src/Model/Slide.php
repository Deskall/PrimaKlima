<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\StaticPublishQueue\Contract\StaticPublishingTrigger;
use SilverStripe\ORM\SS_List;

class Slide extends DataObject implements StaticPublishingTrigger
{

    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText',
        'Effect' => 'Varchar(255)',
        'EffectOptions' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Parent' => SliderBlock::class,
        'Image' => Image::class
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
        'SlideTitle',
        'ImageThumbnail' 
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['SlideTitle'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['ImageThumbnail'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['Title'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['Content'] = _t(__CLASS__.'.ContentLabel','Inhalt');
        $labels['Image'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['CallToActionLink'] = _t(__CLASS__.'.CTA', 'Link');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('SliderID');
        $fields->removeByName('ParentID');
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.Main',DropdownField::create('Effect',_t(__CLASS__.'.Effect','Effekt'), $this->getTranslatedSourceFor(__CLASS__,'effects')));
        $fields->addFieldToTab('Root.Main',TextField::create('EffectOptions',_t(__CLASS__.'.EffectOptions','Effekt Optionen')));
        $fields->FieldByName('Root.Main.Content')->setRows(3);
        $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.ContentTab','Inhalt'));

        return $fields;
    }

    public function SlideTitle(){
        $o = new DBHTMLText();
        $o->setValue($this->Title);
        return $o;
    }

    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? (($this->Image()->getExtension() == "svg" ) ? '<img src="'.$this->Image()->URL.'" class="svg-slide-thumbnail" />' : '<img src="'.$this->Image()->Fill(400,200)->URL.'" />') : _t(__CLASS__.'.NoBild','(keine)');
        $o->setValue($html);
        return $o;
    }

    public function getFolderName(){
        return $this->Parent()->getFolderName();
    }

    public function getPage(){
        return $this->Parent()->getPage();
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

/************** STATIC PUBLISHING ***************/
    /**
     * Provides an SS_List of StaticallyPublishable objects which need to be regenerated.
     *
     * @param array $context An associative array with extra engine-specific information.
     *
     * @return SS_List
     */
    public function objectsToUpdate($context){
        $list = new SS_list();
        $list->add($this->owner->Parent());
        return $list;
    }

    /**
     * Provides a SS_list of objects that need to be deleted.
     *
     * @param array $context An associative array with extra engine-specific information.
     *
     * @return SS_List
     */
    public function objectsToDelete($context){
        $list = new SS_list();
        return $list;
    }
/****************** END STATIC ***********/

}
