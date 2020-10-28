<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;

class TextBlock extends BaseElement implements Searchable
{
    // private static $inline_editable = false;
    
    private static $icon = 'font-icon-block-content';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Text und Bild";

    private static $db = [
        'HTML' => 'HTMLText',
        'LightBox' => 'Boolean(1)'
    ];

    private static $has_one = [
        'ContentImage' => Image::class
    ];

    private static $owns = [
        'ContentImage',
    ];

    private static $defaults = [
        'Layout' => 'left',
        'LightBox' => 1
    ];

    private static $cascade_duplicates = [];


    private static $block_layouts = [
        'left' => 'Links',
        'right' => 'Rechts',
        'hover' => 'Oben', 
        'above' => 'Unten'
    ];

    //  private static $block_layouts = [
    //     'left' => [
    //         'value' => 'left',
    //         'title' => 'Links',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-left.svg'
    //     ],
    //     'right' => [
    //         'value' => 'right',
    //         'title' => 'Rechts',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-right.svg'
    //     ],
    //     'under' => [
    //         'value' => 'under',
    //         'title' => 'Unten',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-under.svg'
    //     ],
    //     'above' => [
    //         'value' => 'above',
    //         'title' => 'Oben',
    //         'icon' => '/_resources/deskall-page-blocks/images/icon-text-above.svg'
    //     ],
    // ];


   
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
        $fields->RemoveByName('LightBox');
        $fields->fieldByName('Root.LayoutTab.TextLayout')->push(OptionsetField::create('Layout',_t(__CLASS__.'.Format','Text und Bild Position'), $this->stat('block_layouts')));
        $fields->insertAfter('Layout',CheckboxField::create('LightBox','Bild vergrößern wenn klickten?'));

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

    /************* SEARCHABLE FUNCTIONS ******************/


        /**
         * Filter array
         * eg. array('Disabled' => 0);
         * @return array
         */
        public static function getSearchFilter() {
            return array();
        }

        /**
         * FilterAny array (optional)
         * eg. array('Disabled' => 0, 'Override' => 1);
         * @return array
         */
        public static function getSearchFilterAny() {
            return array();
        }


        /**
         * Fields that compose the Title
         * eg. array('Title', 'Subtitle');
         * @return array
         */
        public function getTitleFields() {
            return array('Title');
        }

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML');
        }
    /************ END SEARCHABLE ***************************/
}
