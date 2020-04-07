<?php

use DNADesign\ElementalList\Model\ElementList;


use DNADesign\Elemental\Models\ElementalArea;

use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\NumericField;
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
        'CanCollapse' => 'Boolean(1)',
        'HTML' => 'HTMLText',
        'Slide' => 'Boolean(0)',
        'Autoplay' => 'Boolean(0)',
        'Interval' => 'Int',
        'ShowDot' => 'Boolean(1)',
        'ShowNav' => 'Boolean(0)',
        'ShowNavMobile' => 'Boolean(0)',
        'infiniteLoop' => 'Boolean(1)',
        'BlockAlignment' => 'Varchar',
        'BlockVerticalAlignment' => 'Varchar'
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

    private static $extensions = [
        'CollapsableTextExtension'
    ];

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
            'value' => 'uk-child-width-1-1@s uk-child-width-1-2@m',
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

    private static $block_alignments = [
        'uk-flex-left' =>  [
            'value' => 'uk-flex-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-block-left.svg'
        ],
        'uk-flex-right' => [
            'value' => 'uk-flex-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-block-right.svg'
        ],
        'uk-flex-center' =>  [
            'value' => 'uk-flex-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-block-center.svg'
        ],
        'uk-flex-between' =>  [
            'value' => 'uk-flex-between',
            'title' => 'Fügen Sie diese Klasse hinzu, um Elemente gleichmäßig zu verteilen, wobei der Abstand zwischen den Elementen entlang der Hauptachse gleich ist.',
            'icon' => '/deskall-page-blocks/images/icon-block-between.svg'
        ],
         'uk-flex-around' =>  [
            'value' => 'uk-flex-around',
            'title' => 'Fügen Sie diese Klasse hinzu, um Artikel auf beiden Seiten gleichmäßig zu verteilen.',
            'icon' => '/deskall-page-blocks/images/icon-block-around.svg'
        ]
    ];

    private static $block_alignments_vertical = [
        'uk-flex-top' =>  'Oben',
        'uk-flex-middle' => 'Zentriert',
        'uk-flex-bottom' =>  'Boden'
    ];


    private static $defaults = [
        'BlocksPerLine' => 'uk-child-width-1-1@s uk-child-width-1-2@m' 
    ];

    private static $allowed_collapsed_blocks = ['TextBlock','GalleryBlock','ParentBlock'];

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $fields->removeByName('FirstBlockID');
        $fields->removeByName('Layout');
        $fields->removeByName('BlocksPerLine');
        $fields->removeByName('Border');
        $fields->removeByName('matchHeight');
        $fields->removeByName('CollapsableChildren'); 
        $fields->removeByName('CollapseMultipe'); 
        $fields->removeByName('CanCollapse');
        $fields->removeByName('Slide');
        $fields->removeByName('Autoplay');
        $fields->removeByName('ShowDot');
        $fields->removeByName('ShowNav');
        $fields->removeByName('ShowNavMobile');
        $fields->removeByName('infiniteLoop');
        $fields->removeByName('BlockAlignment');
        $fields->removeByName('BlockVerticalAlignment');
        $fields->removeByName('Interval');

        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            HTMLOptionsetField::create('BlocksPerLine',_t(__CLASS__.'.BlocksPerLine','Blöcke per Linie'),$this->stat('blocks_per_line')),
            HTMLOptionsetField::create('BlockAlignment',_t(__CLASS__.'.BlockAlignment','Blockausrichtung'),$this->owner->stat('block_alignments'))->setDescription(_t(__CLASS__.'.BlockAlignmentLabel','Nur gültig wenn die Blöcke per Linie nehmen nicht die ganze Breite.')),
            DropdownField::create('BlockVerticalAlignment',_t(__CLASS__.'.BlockVerticalAlignment','Blockausrichtung (Vertical)'),$this->owner->stat('block_alignments_vertical')),
            CheckboxField::create('Slide',_t(__CLASS__.'.Slide','Blöcke als Gallerie einrichten?')),
            CheckboxField::create('ShowDot',_t(__CLASS__.'.ShowDot','dots anzeigen?')),
            CheckboxField::create('ShowNav',_t(__CLASS__.'.ShowNav','Navigation anzeigen?')),
            CheckboxField::create('ShowNavMobile',_t(__CLASS__.'.ShowNavMobile','Navigation für Mobile anzeigen?')),
            CheckboxField::create('Autoplay',_t(__CLASS__.'.Autoplay','automatiches abspielen?')),
            NumericField::create('Interval',_t(__CLASS__.'.Interval','Interval (millisekunden)')),
            CheckboxField::create('infiniteLoop',_t(__CLASS__.'.inifite','unendlish abspielen?')),
            CheckboxField::create('Border',_t(__CLASS__.'.Border','Border zwischen Blöcke anzeigen')),
            CheckboxField::create('matchHeight',_t(__CLASS__.'.SameHeight','gleiche Höhe für alle Blöcke benutzen'))
        )->setTitle(_t(__CLASS__.'.Layout','Layout'))->setName('Layout'));
        
        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            $collapse = CheckboxField::create('CollapsableChildren',_t(__CLASS__.'.CollapsableChildren','zusammenklappbar Blöcke')),
            CheckboxField::create('CollapseMultipe',_t(__CLASS__.'.CollapseMultipe','Mehrere erweiterten Blöcke erlaubt.'))->displayIf('CollapsableChildren')->isChecked()->end(),
            CheckboxField::create('CanCollapse',_t(__CLASS__.'.CanCollapse','Blöcke dürfen zusammenbrochen sein.'))->displayIf('CollapsableChildren')->isChecked()->end()
        )->setTitle(_t(__CLASS__.'.Settings','Einstellungen'))->setName('BlocksLayout'));

        if ($this->ID > 0){
           $collapse->setDisabled(true)->setDescription(_t(__CLASS__.'.CollapsableChildrenHelpText','Diese Option kann nicht nach dem Erstellung geändert sein.'));
        }

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
