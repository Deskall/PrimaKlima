<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\Tab;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use Bummzack\SortableFile\Forms\SortableUploadField;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class LogosBlock extends BaseElement implements Searchable
{
    private static $inline_editable = false;
    
    private static $icon = 'font-icon-block-carousel';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'PicturesPerLine' => 'Varchar(255)',
        'PictureWidth' => 'Int',
        'PictureHeight' => 'Int',
        'Autoplay' => 'Boolean(0)',
        'ShowDot' => 'Boolean(1)',
        'ShowNav' => 'Boolean(0)',
        'infiniteLoop' => 'Boolean(1)',
        'ImagePadding' => 'Varchar',
        'TextPosition' => 'Varchar'
    ];

    private static $has_many = [
        'Logos' => LogoItem::class
    ];

    private static $owns = [
      'Logos'
    ];

    private static $cascade_duplicates = ['Logos'];

    private static $defaults = [
        'Layout' => 'carousel',
        'PicturesPerLine' => 'uk-child-width-1-2@s uk-child-width-1-3@m'
    ];


    private static $block_layouts = [
        'carousel' => 'Carousel',
        'grid' => 'Grid'
    ];
   
    private static $pictures_per_line = [
        'uk-child-width-1-1' => '1',
        'uk-child-width-1-2@s' => '2',
        'uk-child-width-1-2@s uk-child-width-1-3@m' => '3',
        'uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l' => '4',
        'uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-5@l' => '5',
        'uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-6@l' => '6'
    ];

    private static $image_padding = [
        'dk-padding-s' => 'klein',
        'dk-padding-m' => 'medium',
        'dk-padding-l' => 'gross'
    ];

    private static $table_name = 'LogosBlock';

    private static $singular_name = 'Logogalerie';

    private static $plural_name = 'Logogalerien';

    private static $description = 'Logos als Galerie oder Grid angezeigt.';



    public function getCMSFields()
    {
       
        $this->beforeUpdateCMSFields(function($fields) {
       
            $fields->removeByName('PictureHeight');
            $fields->removeByName('PicturesPerLine');
            $fields->removeByName('PictureWidth');
            $fields->removeByName('Layout');
            $fields->removeByName('Autoplay');
            $fields->removeByName('ShowDot');
            $fields->removeByName('ShowNav');
            $fields->removeByName('infiniteLoop');
            $fields->removeByName('ImagePadding');
            $fields->removeByName('TextPosition');
           
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
         
            $config2 = GridFieldConfig_RecordEditor::create();
            $config2->addComponent(new GridFieldOrderableRows('Sort'));
            if (singleton('LogoItem')->hasExtension('Activable')){
                 $config2->addComponent(new GridFieldShowHideAction());
            }
            $logosField = new GridField('Logos',_t(__CLASS__.'.Logos','Logos'),$this->Logos(),$config2);
            $fields->addFieldToTab('Root.Main',$logosField,'HTML');
            
            $fields->addFieldToTab('Root.LayoutTab',
                CompositeField::create(
                    DropdownField::create('PicturesPerLine',_t(__CLASS__.'.PicturesPerLine','Item per Linie'), self::$pictures_per_line),
                    OptionsetField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')),
                    CheckboxField::create('ShowDot',_t(__CLASS__.'.ShowDot','dots anzeigen?')),
                    CheckboxField::create('ShowNav',_t(__CLASS__.'.ShowNav','Navigation anzeigen?')),
                    CheckboxField::create('Autoplay',_t(__CLASS__.'.Autoplay','automatiches abspielen?')),
                    CheckboxField::create('infiniteLoop',_t(__CLASS__.'.inifite','unendlish abspielen?')),
                    DropdownField::create('ImagePadding',_t(__CLASS__.'.ImagePadding','Bild Abstand'), $this->getTranslatedSourceFor(__CLASS__,'image_padding'))->setEmptyString(_t('Global.None','Keine')),
                    DropdownField::create('TextPosition','Text Position',array('before' => 'Vor den Bildern', 'after' => 'Nach den Bildern'))
                )->setTitle(_t(__CLASS__.'.GalleryBlockLayout','Galerie Layout'))->setName('GalleryBlockLayout')
            );

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
        return _t(__CLASS__ . '.BlockType', 'Logos');
    }


    public function activeLogos(){
        return $this->Logos()->filter('isVisible',1);
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $widthF = 2500;
        $widthN = 1200;
        $refWith = ($this->FullWidth) ? $widthF  : $widthN ;

        switch ($this->Width){
            case 'uk-width-1-1@s uk-width-1-5@m':
            $blockWidth = $refWith * 0.2;
            break;
            case 'uk-width-1-1@s uk-width-1-4@m':
            $blockWidth = $refWith * 0.25;
            break;
            case 'uk-width-1-1@s uk-width-1-3@m':
            $blockWidth = $refWith * 0.333;
            break;
            case 'uk-width-1-1@s uk-width-1-2@m':
            $blockWidth = $refWith * 0.50;
            break;
            case 'uk-width-1-1@s uk-width-2-3@m':
            $blockWidth = $refWith * 0.667;
            break;
            case 'uk-width-1-1@s uk-width-3-4@m':
            $blockWidth = $refWith * 0.75;
            break;
            case 'uk-width-1-1':
            case 'uk-width-auto':
            case 'uk-width-expand':
            $blockWidth = $refWith;
            break;
            default:
                $blockWidth = $refWith;
            break;
        }
       
        $ratio = 1.4;
        $pictures_per_line = ($this->PicturesPerLine) ? static::$pictures_per_line[$this->PicturesPerLine] : 3;
        $width = $blockWidth / $pictures_per_line;
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
         
        foreach($this->stat('image_padding') as $key => $value) {
          $entities[__CLASS__.".image_padding_{$key}"] = $value;
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
        return array('HTML','LogoContent');
    }

    public function getImageContent(){
        $html = '';
        if ($this->Logos()->count() > 0){
            $html .= '<ul>';
            foreach ($this->logos() as $Logo) {
                $html .= '<li>'.$Logo->Title.'</li>';
            }
            $html .='</ul>';
        }
        return $html;
    }
/************ END SEARCHABLE ***************************/
}
