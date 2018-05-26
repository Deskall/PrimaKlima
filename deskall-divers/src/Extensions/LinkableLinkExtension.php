<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\i18n\i18nEntityProvider;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\CMS\Model\SiteTree;

class LinkableLinkExtension extends DataExtension implements i18nEntityProvider
{

    private static $db = [
         'LinkPosition' => 'Varchar(255)',
         'Background' => 'Varchar(255)',
         'Icone' => 'Varchar(255)'
    ];

    private static $types = [
    ];

    private static $defaults = [
        'Icone' => 'chevron-right'
    ];

    private static $block_link_alignments = [
        'left' =>  'Links',
        'center' =>  'Mittel',
        'right' => 'Rechts'
    ];



    function updateFieldLabels(&$labels) {
        $labels['LinkPosition'] = _t(__CLASS__.'.LinkPosition', 'Linkausrichtung');
        $labels['Background'] = _t(__CLASS__.'.Background', 'Link Hintergrundfarbe');
    }


    public function updateCMSFields(FieldList $fields){

        $fields->addFieldToTab('Root',new Tab('Layout',_t(__CLASS__.'.LAYOUTTAB','Layout')));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('LinkPosition',_t(__CLASS__.'.LinkAlignment','Linkausrichtung'),$this->owner->getTranslatedSourceFor(__CLASS__,'block_link_alignments')));
        $fields->addFieldToTab('Root.Layout',HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'));
        $fields->addFieldToTab('Root.Layout', HTMLDropdownField::create('Icone', _t(__CLASS__.'.Icone','Icon'), HTMLDropdownField::getSourceIcones(), 'check')->addExtraClass('columns'));
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        foreach(Config::inst()->get(__CLASS__,'block_link_alignments') as $key => $value) {
          $entities[__CLASS__.".block_link_alignments_{$key}"] = $value;
        }

       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}