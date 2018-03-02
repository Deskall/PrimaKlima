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

    private static $description = 'Orderable list of blocks';
    
    private static $singular_name = 'Parent Block';

    private static $plural_name = 'Parent Blocks';

    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

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
            LayoutField::create('Layout','Layout',static::$block_layouts)
        );
        $fields->addFieldsToTab('Root.Settings',[
            DropdownField::create('BlocksPerLine','Blöcke per Linie',self::$blocks_per_line)->setEmptyString('Blöcke per Linie auswählen'),
            CheckboxField::create('Border','Border zwischen Blöcke ?'),
            CheckboxField::create('matchHeight','gleich Höhe für alle Blöcke ?')
        ]);

        return $fields;
    }
}
