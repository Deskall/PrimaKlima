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
use SilverStripe\CMS\Model\SiteTree;

class LinkableLinkExtension extends DataExtension implements i18nEntityProvider
{

    private static $db = [
         'LinkPosition' => 'Varchar(255)',
         'Background' => 'Varchar(255)',
         'Icone' => 'Varchar(255)',
         'Action' => 'Varchar(255)',
         'Content' => 'HTMLText'
    ];

   /**
     * @var array
     */
    private static $has_one = [
        'Image' => Image::class
    ];

    private static $types = [
        'Action' => 'Aktion an diese Seite'
    ];

    /**
     * @var array
     */
    private static $owns = [
        'Image'
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

    private static $link_actions = [
       'modal' => 'Modal',
       'dropdown' => 'Dropdown',
       'offcanvas' => 'Offcanvas',
       'toggle' => 'Toggle',
       'scroll' => 'Scroll'
    ];



    function updateFieldLabels(&$labels) {
        $labels['LinkPosition'] = _t(__CLASS__.'.LinkPosition', 'Linkausrichtung');
        $labels['Background'] = _t(__CLASS__.'.Background', 'Link Hintergrundfarbe');
    }


    public function updateCMSFields(FieldList $fields){

        $fields->addFieldToTab('Root.Main', DropdownField::create('Action',_t(__CLASS__.'.ActionType','AktionTyp'),$this->owner->getTranslatedSourceFor(__CLASS__,'link_actions') )->setEmptyString(_t(__CLASS__.'ActionLabel','Bitte Aktiontyp auswählen'))->displayIf('Type')->isEqualTo('Action')->end());

        $fields->addFieldToTab('Root',new Tab('Layout',_t(__CLASS__.'.LAYOUTTAB','Layout')));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('LinkPosition',_t(__CLASS__.'.LinkAlignment','Linkausrichtung'),$this->owner->getTranslatedSourceFor(__CLASS__,'block_link_alignments')));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),$this->owner->getTranslatedSourceFor(__CLASS__,'link_backgrounds')));
        $fields->addFieldToTab('Root.Layout',new HTMLDropdownField('Icone', _t(__CLASS__.'.Icone','Icon'), HTMLDropdownField::getSourceIcones(), 'check'));
       
        if ($this->owner->ID > 0){
            $fields->addFieldToTab('Root.Main', $content = HTMLEditorField::create('Content',_t(__CLASS__.'.Content','Inhalt')));
            $fields->fieldByName('Root.Main.Image')->setFolderName($this->owner->getFolderName())->displayIf('Action')->isEqualTo('modal');
            $fields->insertAfter('Content',$fields->fieldByName('Root.Main.Image'));
            $content->displayIf('Action')->isEqualTo('modal');
        }
    }

    public function getFolderName(){
        if ($this->owner->SiteTreeID > 0){
            $page = DataObject::get_by_id(SiteTree::class,$this->owner->SiteTreeID);
            if ($page){
                return $page->generateFolderName();
            }
        }
        return 'Uploads';
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
         foreach(Config::inst()->get(__CLASS__,'link_actions') as $key => $value) {
          $entities[__CLASS__.".link_actions_{$key}"] = $value;
        }

       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}