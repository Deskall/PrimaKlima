<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;

class GalleryBlock extends BaseElement
{
    private static $icon = 'font-icon-block-carousel';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'SortAttribute' => 'Varchar(255)'
    ];

    private static $many_many = [
        'Images' => Image::class
    ];

    private static $many_many_extra_fields = [
        'Images' => ['SortOrder' => 'Int']
    ];

    private static $owns = [
        'Images',
    ];

    private static $defaults = [
        'Layout' => 'carousel'
    ];


    private static $block_layouts = [
        'carousel' => 'Carousel',
        'grid' => 'Grid'
    ];
   
    private static $table_name = 'GalleryBlock';

    private static $singular_name = 'Bildergalerie';

    private static $plural_name = 'Bildergalerien';

    private static $description = 'Bilder als Galerie angezeigt.';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('Images');
            $fields->removeByName('SortAttribute');
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));

            $fields->addFieldToTab('Root.Main',UploadField::create('Images','Bilder')->setIsMultiUpload(true),'HTML')->setFolderName($this->getFolderName());;
            $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout','Format', self::$block_layouts));


            /*** NOT WORKING SINCE SORTABLE IS NOT YET ACTIVE */
           // $fields->addFieldToTab('Root.Main',DropdownField::create('SortAttribute','Sortieren nach',array('SortOrder' => 'Ordnung', 'Filename' => 'Dateiname')),'HTML');

          
        });
        return parent::getCMSFields();
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Bildergalerie');
    }

    public function OrderedImages(){
        return $this->Images()->sort($this->SortAttribute);
    }

}
