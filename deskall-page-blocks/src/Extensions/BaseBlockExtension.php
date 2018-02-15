<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TreeDropdownField;



class BaseBlockExtension extends DataExtension
{

    private static $db = [
        'FullWidth' => 'Boolean(1)',
        'Background' => 'Varchar(255)',
        'Layout' => 'Varchar(255)'
        
    ];

    private static $has_one = [
        'BackgroundImage' => Image::class
    ];

    private static $defaults = [
        'ShowTitle' => 1
    ];

    private static $extensions = [
        'Activable',
        'Linkable'
    ];

    private static $block_layouts = [];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('Background');
        $fields->removeByName('isVisible');
        $fields->removeByName('FullWidth');
    	$fields->addFieldToTab('Root.Settings',CheckboxField::create('FullWidth','volle Breite'));
    	$fields->addFieldToTab('Root.Settings',DropdownField::create('Background','Hintergrundfarbe',array('uk-background-default' => 'kein Hintergrundfarbe', 'uk-background-primary' => 'primäre Farbe', 'uk-background-secondary' => 'sekundäre Farbe', 'uk-background-muted' => 'grau' ))->setDescription('wird als overlay anzeigen falls es ein Hintergrundbild gibt.'));
        $fields->addFieldToTab('Root.Settings',UploadField::create('BackgroundImage','Hintergrundbild')->setFolderName($this->owner->getFolderName()));

    }

    public function getFolderName(){
        return $this->owner->Parent()->getOwnerPage()->generateFolderName();
    }
}