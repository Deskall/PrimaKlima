<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;

class ActionBlock extends BaseElement
{
    private static $icon = 'font-icon-link';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'Trigger' => 'Varchar(255)',
        'Type' => 'Varchar(255)',
        'HTML' => 'HTMLText'
    ];

    private static $has_one = [
        'ContentImage' => Image::class
    ];

    private static $owns = [
        'ContentImage',
    ];

    private static $defaults = [
        'Layout' => 'left'
    ];

    private static $block_actions = [
       'modal' => 'Modal',
       'dropdown' => 'Dropdown',
       'offcanvas' => 'Offcanvas',
       'toggle' => 'Toggle',
       'scroll' => 'Scroll'
    ];

    private static $cascade_duplicates = [];


    private static $block_layouts = [
        'left' => 'Links',
        'right' => 'Rechts',
        'hover' => 'Oben', 
        'above' => 'Unten'
    ];

   
    private static $table_name = 'ActionBlock';

    private static $singular_name = 'Action block';

    private static $plural_name = 'Action blocks';

    private static $description = 'Aktion, die ein Ereignis auslöst (Fenster, Dropdown,...)';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Inhalt'));
            $fields->fieldByName('Root.Main.ContentImage')->setFolderName($this->getFolderName());
            $fields->addFieldToTab('Root.Main',DropdownField::create('Type','Typ', $this->getTranslatedSourceFor(__CLASS__,'block_actions'))->setEmptyString('Bitte Typ auswählen'));
        });
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Layout',LayoutField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')));
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Aktion');
    }

    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
        foreach($this->stat('block_actions') as $key => $value) {
          $entities[__CLASS__.".block_actions_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
