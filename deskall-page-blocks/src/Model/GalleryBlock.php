<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\Tab;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use Bummzack\SortableFile\Forms\SortableUploadField;
use g4b0\SearchableDataObjects\Searchable;

class GalleryBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-block-carousel';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'SortAttribute' => 'Varchar(255)',
        'PicturesPerLine' => 'Varchar(255)',
        'PictureWidth' => 'Int',
        'PictureHeight' => 'Int',
        'Autoplay' => 'Boolean(0)',
        'PaddedImages' => 'Boolean(0)',
        'lightboxOff' => 'Boolean(0)',
        'ShowDot' => 'Boolean(1)',
        'ShowNav' => 'Boolean(0)',
        'Type' => 'Varchar'
    ];

    private static $many_many = [
        'Images' => Image::class,
        'Boxes' => Box::class
    ];

    private static $many_many_extraFields = [
        'Images' => ['SortOrder' => 'Int'],
        'Boxes' => ['SortOrder' => 'Int']
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
        'grid' => 'Grid',
        'card' => 'Card'
    ];

    private static $block_types = [
        'images' => 'Images',
        'boxes' => 'Boxes'
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
       
        $this->beforeUpdateCMSFields(function($fields) {
       
            $fields->removeByName('Images');
            $fields->removeByName('PictureHeight');
            $fields->removeByName('PicturesPerLine');
            $fields->removeByName('PictureWidth');
            $fields->removeByName('SortAttribute');
            $fields->removeByName('Layout');
            $fields->removeByName('Autoplay');
            $fields->removeByName('ShowDot');
            $fields->removeByName('ShowNav');
            $fields->removeByName('PaddedImages');
             $fields->removeByName('lightboxOff');
           $fields->addFieldToTab('Root.Main',DropdownField::create('Type','Item Typ',array('images' => 'Bilder', 'boxes' => 'Boxen')),'Title');
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
          
            $fields->addFieldToTab('Root.Main',SortableUploadField::create('Images',_t(__CLASS__.'.Images','Bilder'))->setIsMultiUpload(true)->setFolderName($this->getFolderName()),'HTML');

            $fields->addFieldToTab('Root.LayoutTab',
                CompositeField::create(
                    DropdownField::create('PicturesPerLine',_t(__CLASS__.'.PicturesPerLine','Bilder per Linie'), self::$pictures_per_line),
                    OptionsetField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')),
                    CheckboxField::create('ShowDot',_t(__CLASS__.'.ShowDot','dots anzeigen?')),
                    CheckboxField::create('ShowNav',_t(__CLASS__.'.ShowNav','Navigation anzeigen?')),
                    CheckboxField::create('Autoplay',_t(__CLASS__.'.Autoplay','automatiches Abspielen?')),
                    CheckboxField::create('PaddedImages',_t(__CLASS__.'.PaddedImages','Bilder vollständig anzeigen? (keine Größenanpassung, beispielsweise für Logos angegeben)')),
                    CheckboxField::create('lightboxOff',_t(__CLASS__.'.LightboxOff','Bilder nicht anklickbar?'))
                )->setTitle(_t(__CLASS__.'.GalleryBlockLayout','Galerie Layout'))->setName('GalleryBlockLayout')
            );
            
           $fields->addFieldToTab('Root.Main',DropdownField::create('SortAttribute','Sortieren nach',array('SortOrder' => 'Ordnung', 'Filename' => 'Dateiname')),'HTML');


        });
     $fields = parent::getCMSFields();
      

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
         foreach($this->stat('block_types') as $key => $value) {
          $entities[__CLASS__.".block_types_{$key}"] = $value;
        }

       
        return $entities;
    }

/************* END TRANLSATIONS *******************/

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
        return array('HTML','ImageContent');
    }

    public function getImageContent(){
        $html = '';
        if ($this->Images()->count() > 0){
            $html .= '<ul>';
            foreach ($this->Images() as $image) {
                $html .= '<li>'.$image->Title."\n";
                if ($image->Description){
                    $html .= $image->Description;
                }
                $html .= '</li>';
            }
            $html .='</ul>';
        }
        return $html;
    }
/************ END SEARCHABLE ***************************/
}
