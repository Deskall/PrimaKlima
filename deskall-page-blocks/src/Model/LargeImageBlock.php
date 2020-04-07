<?php

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\FieldType\DBField;
use g4b0\SearchableDataObjects\Searchable;

class LargeImageBlock extends BaseElement implements Searchable{
	private static $icon = 'font-icon-image';

	private static $singular_name = 'banner';

    private static $plural_name = 'banners';

    private static $description = 'Banner Bild mit Text und Effekt Möglichkeiten';

    private static $controller_template = 'ElementHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
    	'Effect' => 'Varchar(255)',
    	'EffectOptions' => 'Varchar(255)',
    	'Overlay' => 'Varchar(255)',
        'Height' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $defaults = [
        'Layout' => 'dk-position-top',
        'Effect' => 'none',
        'Overlay' => 'none',
        'Height' => 'dk-height-medium'
    ];

    private static $cascade_duplicates = [];


    private static $block_layouts = [
        "dk-position-top" => "Positions the element at the top",
        "dk-position-center-left" => "Positions the element vertically centered in the middle.",
        "dk-position-bottom" => "Positions the element at the bottom"
    ];

    private static $block_heights = [
        'dk-height-small' => 'klein',
        'dk-height-medium' => 'medium',
        'dk-height-large' => 'gross',
        'viewport' => 'ganz Bildschirm'
    ];

    private static $effects = [
        'none' => 'kein',
        'fixed' => 'fixed',
        'kenburns' => 'Ken Burns',
        'parallax' => 'parallax' 
    ];

    private static $extensions = [
        'CollapsableTextExtension'
    ];


    public function getCMSFields(){
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Inhalt'));
        });
        $fields = parent::getCMSFields();
        $fields->RemoveByName('Layout');
        
    	$fields->removeByName('RelatedPageID');
        $fields->removeByName('CallToActionLink');
    	$fields->removeByName('BackgroundImage');
        $fields->removeByName('File');
        $fields->removeByName('Layout');
        $fields->removeByName('Height');
        $fields->removeByName('Effect');
        $fields->removeByName('EffectOptions');
         $fields->removeByName('Overlay');
         $fields->removeByName('BackgroundImageEffect');
        $fields->fieldByName('Root.Main.Image')->setTitle(_t(__CLASS__ . '.Image','Bild'))->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            OptionsetField::create('Layout',_t(__CLASS__. '.Format','vertikale Ausrichtung'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')),
            OptionsetField::create('Height',_t(__CLASS__. '.Height','Höhe'),$this->getTranslatedSourceFor(__CLASS__,'block_heights')),
            OptionsetField::create('Effect',_t(__CLASS__. '.Effect','Effekt'),$this->getTranslatedSourceFor(__CLASS__,'effects')),
            TextField::create('EffectOptions',_t(__CLASS__. '.EffectOptions','Effekt Optionen'))
          )->setTitle(_t(__CLASS__.'BlockLayout','Layout'))->setName('BlockLayout')
        );


        
    	return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Banner');
    }


    public function ImageHeight(){
        switch($this->Height){
            case "dk-height-small":
            return 150;
            break;
            case "dk-height-medium":
            return 350;
            break;
            case "dk-height-large":
            return 450;
            break;
            case "viewport":
            return 700;
        }
    }
    

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
        foreach($this->stat('block_heights') as $key => $value) {
          $entities[__CLASS__.".block_heights_{$key}"] = $value;
        }
        foreach($this->stat('effects') as $key => $value) {
          $entities[__CLASS__.".effects_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/

/************* SEARCHABLE FUNCTIONS ******************/


    /**
     * Filter array
     * eg. array('Disabled' => 0);
     * @return array
     */
    public static function getSearchFilter() {
        return array();
    }

    /**
     * FilterAny array (optional)
     * eg. array('Disabled' => 0, 'Override' => 1);
     * @return array
     */
    public static function getSearchFilterAny() {
        return array();
    }


    /**
     * Fields that compose the Title
     * eg. array('Title', 'Subtitle');
     * @return array
     */
    public function getTitleFields() {
        return array('Title');
    }

    /**
     * Fields that compose the Content
     * eg. array('Teaser', 'Content');
     * @return array
     */
    public function getContentFields() {
        return array('Content');
    }

/************ END SEARCHABLE ***************************/

}