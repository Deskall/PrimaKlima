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
use SilverStripe\ElementalBlocks\Block\BannerBlock;
use SilverStripe\ORM\FieldType\DBField;

class LargeImageBlock extends BannerBlock{
	private static $icon = 'font-icon-image';

	private static $singular_name = 'banner';

    private static $plural_name = 'banners';

    private static $controller_template = 'DefaultHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
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
        'Layout' => 'uk-position-top',
        'Effect' => 'none',
        'Overlay' => 'none',
        'Height' => 'uk-height-medium'
    ];

    private static $cascade_duplicates = [];


    private static $block_layouts = [
        "uk-position-top" => "Positions the element at the top",
        "uk-position-center" => "Positions the element vertically centered in the middle.",
        "uk-position-bottom" => "Positions the element at the bottom"
    ];

    private static $block_heights = [
        'uk-height-small' => 'klein',
        'uk-height-medium' => 'medium',
        'uk-height-large' => 'gross',
        'viewport' => 'ganz Bildschirm'
    ];

    private static $effects = [
        'none' => 'kein',
        'fixed' => 'fixed',
        'ken-burns' => 'Ken Burns',
        'parallax' => 'parallax' 
    ];


    public function getCMSFields(){
    	$fields = parent::getCMSFields();
    	$fields->removeByName('RelatedPageID');
        $fields->removeByName('CallToActionLink');
    	$fields->removeByName('BackgroundImage');
        $fields->removeByName('File');
        $fields->removeByName('Layout');
        $fields->removeByName('Height');
        $fields->removeByName('Effect');
        $fields->removeByName('EffectOptions');
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
            case "uk-height-small":
            return 150;
            break;
            case "uk-height-medium":
            return 350;
            break;
            case "uk-height-large":
            return 450;
            break;
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

}