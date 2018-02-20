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
      // 'ken-burns' => 'Ken Burns',
        'parallax' => 'parallax'
    ];


    public function getCMSFields(){
    	$fields = parent::getCMSFields();
    	$fields->removeByName('RelatedPageID');
    	$fields->removeByName('Background');
        $fields->removeByName('Overlay');
    	$fields->removeByName('BackgroundImage');
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout','Format', self::$block_layouts));
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Height','Höhe',self::$block_heights));
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Effect','Effect',self::$effects));
        $fields->addFieldToTab('Root.Settings',TextField::create('EffectOptions','Effect Optionen'));
        
    	return $fields;
    }

}