<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\Tab;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use Bummzack\SortableFile\Forms\SortableUploadField;

class GalleryBlock extends BaseElement
{
    private static $icon = 'font-icon-block-carousel';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'SortAttribute' => 'Varchar(255)',
        'PicturesPerLine' => 'Varchar(255)',
        'PictureWidth' => 'Int',
        'PictureHeight' => 'Int'
    ];

    private static $many_many = [
        'Images' => Image::class
    ];

    private static $many_many_extraFields = [
        'Images' => ['SortOrder' => 'Int']
    ];

    private static $owns = [
        'Images',
    ];

    private static $cascade_duplicates = [];

    private static $defaults = [
        'Layout' => 'carousel',
        'PicturesPerLine' => 'uk-child-width-1-3@s'
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
        $fields = parent::getCMSFields();

       
            $fields->removeByName('Images');
            $fields->removeByName('PictureHeight');
            $fields->removeByName('PicturesPerLine');
            $fields->removeByName('PictureWidth');
            $fields->removeByName('SortAttribute');
            $fields->removeByName('Layout');
           
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
          
            $fields->addFieldToTab('Root.Main',SortableUploadField::create('Images',_t(__CLASS__.'.Images','Bilder'))->setIsMultiUpload(true)->setFolderName($this->getFolderName(),'HTML'));

            $fields->addFieldToTab('Root.LayoutTab',
                CompositeField::create(
                    DropdownField::create('PicturesPerLine',_t(__CLASS__.'.PicturesPerLine','Bilder per Linie'), self::$pictures_per_line),
                    OptionsetField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')
                ))->setTitle(_t(__CLASS__.'.GalleryBlockLayout','Galerie Layout'))->setName('GalleryBlockLayout')
            );
            


            /*** NOT WORKING SINCE SORTABLE IS NOT YET ACTIVE */
           // $fields->addFieldToTab('Root.Main',DropdownField::create('SortAttribute','Sortieren nach',array('SortOrder' => 'Ordnung', 'Filename' => 'Dateiname')),'HTML');

          
    
      

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

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $widthF = 2500;
        $widthN = 1200;
        $ratio = 1.4; 
        $width = ($this->FullWidth) ? $widthF / static::$pictures_per_line[$this->PicturesPerLine] : $widthN /  static::$pictures_per_line[$this->PicturesPerLine];
        $height = $width / $ratio;

        $this->PictureWidth = $width;
        $this->PictureHeight = $height;
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
