<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;



class BaseBlockExtension extends DataExtension
{

    private static $db = [
        'FullWidth' => 'Boolean(0)',
        'Background' => 'Varchar(255)',
        'Layout' => 'Varchar(255)'
    ];

    private static $has_one = [
        'BackgroundImage' => Image::class
    ];

    private static $defaults = [
        'ShowTitle' => 1
    ];


    private static $block_backgrounds = [
        'no-bg' => 'keine Hintergrundfarbe',
        'uk-background-primary' => 'primäre Farbe',
        'uk-background-secondary' => 'sekondäre Farbe',
        'uk-background-muted' => 'grau',
        'dk-background-white uk-background' => 'weiss',
    ];

    

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('Background');
        $fields->removeByName('FullWidth');
    	$fields->addFieldToTab('Root.Settings',CheckboxField::create('FullWidth','volle Breite'));
    	$fields->addFieldToTab('Root.Settings',DropdownField::create('Background','Hintergrundfarbe',self::$block_backgrounds)->setDescription('wird als overlay anzeigen falls es ein Hintergrundbild gibt.'));
        $fields->addFieldToTab('Root.Settings',UploadField::create('BackgroundImage','Hintergrundbild')->setFolderName($this->owner->getFolderName()));

    }

    public function getFolderName(){
        return $this->owner->Parent()->getOwnerPage()->generateFolderName();
    }

}