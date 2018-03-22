<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Config;
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

    private static $block_link_alignments = [
        'left' =>  'Links',
        'center' =>  'Mittel',
        'right' => 'Rechts'
    ];

    private static $link_backgrounds = [
        'uk-button-default' => 'keine Hintergrundfarbe',
        'uk-section-primary dk-text-hover-primary' => 'primäre Farbe',
        'uk-section-secondary dk-text-hover-secondary' => 'sekundäre Farbe',
        'uk-section-muted dk-text-hover-muted' => 'grau',
        'dk-background-white uk-section-default dk-text-hover-white' => 'weiss',
        'dk-background-black uk-section-default dk-text-hover-black' => 'schwarz'
    ];



    function updateFieldLabels(&$labels) {
        $labels['LinkPosition'] = _t(__CLASS__.'.LinkPosition', 'Linkausrichtung');
        $labels['Background'] = _t(__CLASS__.'.Background', 'Link Hintergrundfarbe');
    }


    public function updateCMSFields(FieldList $fields){

        $fields->addFieldToTab('Root.Main', DropdownField::create('Action',_t(__CLASS__.'.ActionType','AktionTyp'),$this->owner->getTranslatedSourceFor(__CLASS__,'link_actions') )->setEmptyString(_t(__CLASS__.'ActionLabel','Bitte Aktiontyp auswählen'))->displayIf('Type')->isEqualTo('ActionType')->end());

        $fields->addFieldToTab('Root',new Tab('Layout',_t(__CLASS__.'.LAYOUTTAB','Layout')));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('LinkPosition',_t(__CLASS__.'.LinkAlignment','Linkausrichtung'),$this->owner->getTranslatedSourceFor(__CLASS__,'block_link_alignments')));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),$this->owner->getTranslatedSourceFor(__CLASS__,'link_backgrounds')));
        $fields->addFieldToTab('Root.Layout',new HTMLDropdownField('Icone', _t(__CLASS__.'.Icone','Icon'), HTMLDropdownField::getSourceIcones(), 'check'));
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        foreach(Config::inst()->get(__CLASS__,'block_link_alignments') as $key => $value) {
          $entities[__CLASS__.".block_link_alignments_{$key}"] = $value;
        }
        foreach(Config::inst()->get(__CLASS__,'link_backgrounds') as $key => $value) {
          $entities[__CLASS__.".link_backgrounds_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}