<?php

use DNADesign\ElementalList\Model\ElementList;


use DNADesign\Elemental\Models\ElementalArea;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\CompositeField;

class ParentBlock extends ElementList
{
   
    private static $db = [
        'BlocksPerLine' => 'Varchar(255)',
        'Border' => 'Boolean(0)',
        'matchHeight' => 'Boolean(1)',
        'FirstBlockID' => 'Int',
        'CollapsableChildren' => 'Boolean(0)',
        'CollapseMultipe' => 'Boolean(1)',
        'CanCollapse' => 'Boolean(1)'
    ];

    private static $table_name = 'ParentBlock';

    private static $title = 'Group';

    private static $icon = 'font-icon-block-layout';

    private static $description = 'Orderable list of blocks';
    
    private static $singular_name = 'Parent Block';

    private static $plural_name = 'Parent Blocks';

    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $cascade_duplicates = ['Elements'];

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Parent Block');
    }

    private static $blocks_per_line = [
        'uk-child-width-1-1@s' => [
            'value' => 'uk-child-width-1-1@s',
            'title' => '1 Spalte',
            'icon' => '/deskall-page-blocks/images/icon-parent-1-columns.svg'
        ],
        'uk-child-width-1-1@s uk-child-width-1-2@m' => [
            'value' => 'uk-child-width-1-1@s',
            'title' => '2 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-parent-2-columns.svg'
        ],
        'uk-child-width-1-1@s uk-child-width-1-3@m' => [
            'value' => 'uk-child-width-1-1@s uk-child-width-1-3@m',
            'title' => '3 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-parent-3-columns.svg'
        ],
        'uk-child-width-1-1@s uk-child-width-1-4@m' => [
            'value' => 'uk-child-width-1-1@s uk-child-width-1-4@m',
            'title' => '4 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-parent-4-columns.svg'
        ]
    ];


    private static $defaults = [
        'BlocksPerLine' => 'uk-child-width-1-1@s uk-child-width-1-2@m' 
    ];

    private static $allowed_collapsed_blocks = ['TextBlock','GalleryBlock'];

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->removeByName('FirstBlockID');
        $fields->removeByName('LinkableLinkID');
        $fields->removeByName('Layout');
        $fields->removeByName('BlocksPerLine');
        $fields->removeByName('Border');
        $fields->removeByName('matchHeight'); 

        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            HTMLOptionsetField::create('BlocksPerLine',_t(__CLASS__.'.BlocksPerLine','Blöcke per Linie'),$this->stat('blocks_per_line')),
            CheckboxField::create('Border',_t(__CLASS__.'.Border','Border zwischen Blöcke anzeigen')),
            CheckboxField::create('matchHeight',_t(__CLASS__.'.SameHeight','gleiche Höhe für alle Blöcke benutzen'))
        )->setTitle(_t(__CLASS__.'.Layout','Layout'))->setName('Layout'));
        
        $fields->addFieldsToTab('Root.Settings',[
            CheckboxField::create('CollapsableChildren',_t(__CLASS__.'.CollapsableChildren','zusammenklappbar Blöcke')),
            CheckboxField::create('CollapseMultipe',_t(__CLASS__.'.CollapseMultipe','Mehrere erweiterten Blöcke erlaubt.'))->displayIf('CollapsableChildren')->isChecked()->end(),
            CheckboxField::create('CanCollapse',_t(__CLASS__.'.CanCollapse','Blöcke dürfen zusammenbrochen sein.'))->displayIf('CollapsableChildren')->isChecked()->end()
        ]);

        return $fields;
    }

     /*** Duplicate block with correct elements */
    public function DuplicateChildrens($original){
        foreach (Config::inst()->get($original->ClassName,'owns') as $class) {
            foreach($original->{$class}() as $object){
                $newObject = $object->duplicate(false);
                $newObject->ParentID = $this->ID;
                $newObject->write();
            }
        }
    }

    public function ExpandedBlocks(){
        return json_encode($this->Elements()->Elements()->filter('collapsed',0)->column('ID'));
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('blocks_per_line') as $key => $value) {
          $entities[__CLASS__.".blocks_per_line_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
