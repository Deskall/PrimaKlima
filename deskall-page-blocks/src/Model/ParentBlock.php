<?php

use DNADesign\ElementalList\Model\ElementList;


use DNADesign\Elemental\Models\ElementalArea;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;

class ParentBlock extends ElementList
{
   
    private static $db = [
        'BlocksPerLine' => 'Varchar(255)',
        'Border' => 'Boolean(0)',
        'matchHeight' => 'Boolean(1)',
        'FirstBlockID' => 'Int'
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
        'uk-child-width-1-1@s' => '1',
        'uk-child-width-1-1@s uk-child-width-1-2@m' => '2',
        'uk-child-width-1-1@s uk-child-width-1-3@m' => '3',
        'uk-child-width-1-1@s uk-child-width-1-4@m' => '4',
    ];

    private static $block_layouts = [
        'default' => 'default'
    ];

    private static $defaults = [
        'BlocksPerLine' => 'uk-child-width-1-1@s uk-child-width-1-2@m' 
    ];

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->removeByName('FirstBlockID');
        $fields->addFieldToTab('Root.Layout',
            LayoutField::create('Layout','Layout',$this->getTranslatedSourceFor(__CLASS__,'block_layouts'))
        );
        $fields->addFieldsToTab('Root.Settings',[
            DropdownField::create('BlocksPerLine',_t(__CLASS__.'.BlocksPerLine','Blöcke per Linie'),$this->getTranslatedSourceFor(__CLASS__,'blocks_per_line'))->setEmptyString(_t(__CLASS__.'.BlocksPerLineHelpText','Blöcke per Linie auswählen')),
            CheckboxField::create('Border',_t(__CLASS__.'.Border','Border zwischen Blöcke ?')),
            CheckboxField::create('matchHeight',_t(__CLASS__.'.SameHeight','gleich Höhe für alle Blöcke ?'))
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

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('blocks_per_line') as $key => $value) {
          $entities[__CLASS__.".blocks_per_line_{$key}"] = $value;
        }
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
