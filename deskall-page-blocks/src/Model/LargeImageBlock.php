<?php

use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
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

    private static $defaults = [
        'FullWidth' => 1,
        'Layout' => 'left',
        'Effect' => 'none',
        'Overlay' => 'none'
    ];

    private static $cascade_duplicates = [];


    private static $block_layouts = [
        "uk-position-top-left" => "Positions the element at the top left.",
        "uk-position-top-center" => "Positions the element at the top center.",
        "uk-position-top-right" => "Positions the element at the top right.",
        "uk-position-center" => "Positions the element vertically centered in the middle.",
        "uk-position-center-left" => "Positions the element vertically centered on the left.",
        "uk-position-center-right" => "Positions the element vertically centered on the right.",
        "uk-position-bottom-left" => "Positions the element at the bottom left.",
        "uk-position-bottom-center" => "Positions the element at the bottom center.",
        "uk-position-bottom-right" => "Positions the element at the bottom right."
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
    	$fields->removeByName('Background');
        $fields->removeByName('Overlay');
    	$fields->removeByName('BackgroundImage');
        $fields->fieldByName('Root.Main.File')->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout',_t(__CLASS__. '.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')));
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Height',_t(__CLASS__. '.Height','Höhe'),$this->getTranslatedSourceFor(__CLASS__,'block_heights')));
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Effect',_t(__CLASS__. '.Effect','Effekt'),$this->getTranslatedSourceFor(__CLASS__,'effects')));
        $fields->addFieldToTab('Root.Settings',TextField::create('EffectOptions',_t(__CLASS__. '.EffectOptions','Effekt Optionen')));
        
    	return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
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