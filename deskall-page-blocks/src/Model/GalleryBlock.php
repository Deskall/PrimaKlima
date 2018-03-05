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
        'SortAttribute' => 'Varchar(255)',
        'PicturesPerLine' => 'Int'
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
    
    private static $pictures_per_line = [
        'uk-child-width-1-1' => '1',
        'uk-child-width-1-2@s' => '2',
        'uk-child-width-1-3@s' => '3',
        'uk-child-width-1-2@s uk-child-width-1-4@m' => '4',
        'uk-child-width-1-2@s uk-child-width-1-5@m' => '5'
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

            $fields->addFieldToTab('Root.Main',UploadField::create('Images','Bilder')->setIsMultiUpload(true)->setFolderName($this->getFolderName(),'HTML'));
            $fields->addFieldToTab('Root.Layout',DropdownField::create('PicturesPerLine','Bilder per Linie', self::$pictures_per_line));

            


            /*** NOT WORKING SINCE SORTABLE IS NOT YET ACTIVE */
           // $fields->addFieldToTab('Root.Main',DropdownField::create('SortAttribute','Sortieren nach',array('SortOrder' => 'Ordnung', 'Filename' => 'Dateiname')),'HTML');

          
        });
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout','Format', self::$block_layouts));
        return $fields;
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
