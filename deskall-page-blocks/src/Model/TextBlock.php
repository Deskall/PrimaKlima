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


    // private static $block_layouts = [
    //     'left' => 'Links',
    //     'right' => 'Rechts',
    //     'hover' => 'Oben', 
    //     'above' => 'Unten'
    // ];

     private static $block_layouts = [
        'left' => [
            'value' => 'left',
            'title' => 'Links',
            'icon' => '/deskall-page-blocks/images/icon-text-left.svg'
        ],
        'right' => [
            'value' => 'right',
            'title' => 'Rechts',
            'icon' => '/deskall-page-blocks/images/icon-text-right.svg'
        ],
        'under' => [
            'value' => 'under',
            'title' => 'Unten',
            'icon' => '/deskall-page-blocks/images/icon-text-under.svg'
        ],
        'above' => [
            'value' => 'above',
            'title' => 'Oben',
            'icon' => '/deskall-page-blocks/images/icon-text-above.svg'
        ],
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
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Inhalt'));
            $fields->fieldByName('Root.Main.ContentImage')->setFolderName($this->getFolderName());
        });
        $fields = parent::getCMSFields();
        $fields->RemoveByName('Layout');
        $fields->fieldByName('Root.LayoutTab.TextLayout')->push(HTMLOptionsetField::create('Layout',_t(__CLASS__.'.Format','Text und Bild Position'), $this->stat('block_layouts')));
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
