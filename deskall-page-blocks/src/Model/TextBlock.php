<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;

class TextBlock extends BaseElement
{
    private static $icon = 'font-icon-block-content';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Text und Bild";

    private static $db = [
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

    private static $cascade_duplicates = [];


    private static $block_layouts = [
        'left' => 'Links',
        'right' => 'Rechts',
        'hover' => 'Oben', 
        'above' => 'Unten'
    ];

   
    private static $table_name = 'TextBlock';

    private static $singular_name = 'Content block';

    private static $plural_name = 'Content blocks';

    private static $description = 'Content as text and image';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
            $fields->fieldByName('Root.Main.ContentImage')->setFolderName($this->getFolderName());
        });
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Layout',LayoutField::create('Layout','Format', self::$block_layouts));
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Text - Bild');
    }

}
