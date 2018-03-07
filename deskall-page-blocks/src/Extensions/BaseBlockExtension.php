<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\Tab;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;

class BaseBlockExtension extends DataExtension
{

    private static $db = [
        'FullWidth' => 'Boolean(0)',
        'Background' => 'Varchar(255)',
        'Layout' => 'Varchar(255)',
        'TextAlign' => 'Varchar(255)',
        'TextColumns' => 'Varchar(255)',
        'TextColumnsDivider' => 'Boolean(0)'
    ];

    private static $has_one = [
        'BackgroundImage' => Image::class,
        'ExampleLink' => Link::class
    ];

    private static $owns =[
        'BackgroundImage'
    ];

    private static $defaults = [
        'ShowTitle' => 1,
        'Background' => 'no-bg',
        'Align' => 'uk-text-left'
    ];


    private static $block_backgrounds = [
        'uk-section-default' => 'keine Hintergrundfarbe',
        'uk-section-primary' => 'primäre Farbe',
        'uk-section-secondary' => 'sekundäre Farbe',
        'uk-section-muted' => 'grau',
        'dk-background-white uk-section-default' => 'weiss',
    ];

    private static $block_text_alignments = [
        'uk-text-justify uk-text-left@s' =>  'Aligns text to the left.',
        'uk-text-justify uk-text-righ@st' =>  'Aligns text to the right',
        'uk-text-justify uk-text-center@s' => 'Centers text horizontally',
        'uk-text-justify' => 'Justifies text'
    ];

    private static $block_text_columns = [
        ' ' => 'Keine Spalten',
        'uk-column-1-2@s' => 'Display the content in two columns',
        'uk-column-1-2@s uk-column-1-3@m' => 'Display the content in three columns',
        'uk-column-1-2@s uk-column-1-4@m' => 'Display the content in four columns',
        'uk-column-1-2@s uk-column-1-4@m uk-column-1-5@l' => 'Display the content in five columns',
        'uk-column-1-2@s uk-column-1-4@m uk-column-1-6@l' => 'Display the content in six columns'
    ];
    

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('Background');
        $fields->removeByName('BackgroundImage');
        $fields->removeByName('FullWidth');
      
        $fields->removeByName('TextAlign');
        $fields->removeByName('TextColumns');
        $fields->removeByName('TextColumnsDivider');
        $extracss = $fields->fieldByName('Root.Settings.ExtraClass');
        $fields->removeByName('ExtraClass');
        $fields->addFieldToTab('Root',new Tab('Layout',_t('BLOCKS.LAYOUTTAB','Layout')),'Settings');
    	$fields->addFieldToTab('Root.Layout',CheckboxField::create('FullWidth','volle Breite'));
        $fields->addFieldToTab('Root.Layout',$extracss);
    	$fields->addFieldToTab('Root.Layout',DropdownField::create('Background','Hintergrundfarbe',self::$block_backgrounds)->setDescription('wird als overlay anzeigen falls es ein Hintergrundbild gibt.'));
        $fields->addFieldToTab('Root.Layout',UploadField::create('BackgroundImage','Hintergrundbild')->setFolderName($this->owner->getFolderName()));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('TextAlign','Textausrichtung',self::$block_text_alignments));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('TextColumns','Text in mehreren Spalten',self::$block_text_columns));
        $fields->addFieldToTab('Root.Layout',$columnDivider = CheckboxField::create('TextColumnsDivider','Border zwischen Spalten anzeigen'));
        
        $fields->addFieldToTab('Root.Link', LinkField::create('ExampleLinkID', 'Link to page or file'));
    }

    public function getFolderName(){

        $parent = $this->owner->Parent()->getOwnerPage();
       
        while(!$parent->hasMethod('generateFolderName')){
            $parent = $parent->Parent()->getOwnerPage();
        }
        return $parent->generateFolderName();
    }

    public function onBeforeWrite(){
        if (!$this->owner->Sort){
            $last = $this->owner->Parent()->Elements()->sort('Sort','DESC')->first();
            $this->owner->Sort = ($last) ? $last->Sort + 1 : 1;
        }
        parent::onBeforeWrite();
    }

    public function isChildren(){
        return $this->owner->Parent()->OwnerClassName == "ParentBlock";
    }

    public function isFirst(){
        if ($this->owner->isChildren()){
            return $this->owner->ID == $this->owner->Parent()->getOwnerPage()->Elements()->Elements()->first()->ID;
        }
        return false;
    }

   

    public function isFirstMobile(){
        if ($this->owner->isChildren()){
            return $this->owner->ID == $this->owner->Parent()->getOwnerPage()->FirstBlockID;
        }
        return false;
    }

   


}