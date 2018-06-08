<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class SliderBlock extends BaseElement
{
    private static $icon = 'font-icon-block-banner';
    
    private static $controller_template = 'DefaultHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'Type' => 'Varchar(255)',
        'Animation' => 'Varchar(255)',
        'Autoplay' => 'Boolean(1)',
        'Nav' => 'Varchar(255)',
        'Height' => 'Varchar(255)',
        'MinHeight' => 'Varchar(255)',
        'MaxHeight' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Referent' => SliderBlock::class
    ];

    private static $has_many = [
        'Slides' => Slide::class
    ];

    private static $owns = [
        'Slides',
    ];

    private static $cascade_deletes = [
        'Slides',
    ];

    private static $cascade_duplicates = [
        'Slides',
    ];

    private static $block_types = [
        'video' =>  [
            'value' => 'video',
            'title' => 'Video',
            'icon' => '/deskall-page-blocks/images/icon-video.svg'
        ],
        'image' =>  [
            'value' => 'Image',
            'title' => 'Bild',
            'icon' => '/deskall-page-blocks/images/icon-image.svg'
        ]
    ];

    private static $block_text_alignments = [
        'uk-text-left' =>  [
            'value' => 'uk-text-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'uk-text-right' => [
            'value' => 'uk-text-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-right-align.svg'
        ],
        'uk-text-center' =>  [
            'value' => 'uk-text-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-center-align.svg'
        ],
        'uk-text-justify' =>  [
            'value' => 'uk-text-justify',
            'title' => 'Justify Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-justify-align.svg'
        ]
    ];


    private static $defaults = [
        'Layout' => 'slideshow',
        'FullWidth' => 1,
        'MinHeight' => '250',
        'Height' => 'viewport',
        'TextAlign' => 'uk-text-left',
        'TitleAlign' => 'uk-text-left'
    ];

    private static $block_layouts = [
        'slideshow' => [
            'value' => 'slideshow',
            'title' => 'Slideshow',
            'icon' => '/deskall-page-blocks/images/icon-slide-fullwidth.svg'
        ],
        'slider' => [
            'value' => 'slider',
            'title' => 'Slider',
            'icon' => '/deskall-page-blocks/images/icon-slide-contained.svg'
        ],
    ];


    private static $block_heights = [
        'small' => [
            'value' => 'small',
            'title' => 'klein',
            'icon' => '/deskall-page-blocks/images/icon-slide-fullwidth.svg'
        ],
        'medium' => [
            'value' => 'medium',
            'title' => 'mittel',
            'icon' => '/deskall-page-blocks/images/icon-slide-medium.svg'
        ],
        'large' => [
            'value' => 'large',
            'title' => 'gross',
            'icon' => '/deskall-page-blocks/images/icon-slide-large.svg'
        ],
        'viewport' => [
            'value' => 'viewport',
            'title' => 'Vollbild',
            'icon' => '/deskall-page-blocks/images/icon-slide-fullscreen.svg'
        ],
    ];

    private static $animations = [
        'slide' => 'slide',
        'fade' => 'fade',
        'scale' => 'scale',
        'pull' => 'pull',
        'push' => 'push'
    ];
   
    private static $controls = [
        'none' => [
            'value' => 'none',
            'title' => 'klein',
            'icon' => '/deskall-page-blocks/images/icon-slide-fullscreen.svg'
        ],
        'dots' => [
            'value' => 'dots',
            'title' => 'Dots',
            'icon' => '/deskall-page-blocks/images/icon-slide-dots.svg'
        ],
        'controls' => [
            'value' => 'controls',
            'title' => 'Kontrol',
            'icon' => '/deskall-page-blocks/images/icon-slide-arrows.svg'
        ],
        'both' => [
            'value' => 'both',
            'title' => 'Beides',
            'icon' => '/deskall-page-blocks/images/icon-slide-both.svg'
        ],
    ];

    private static $table_name = 'SliderBlock';

    private static $singular_name = 'Slideshow';

    private static $plural_name = 'Slideshow';

    private static $description = 'Bilder oder Videos als Slide angezeigen.';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
      
            $fields->removeByName('TitleAndDisplayed');
            $fields->removeByName('RelatedPageID');
            $fields->removeByName('Slides');
            $fields->removeByName('ReferentID');
            $fields->removeByName('Height');
            $fields->removeByName('Layout');
            $fields->removeByName('Nav');
            $fields->removeByName('Autoplay');
            $fields->removeByName('Animation');
            $fields->removeByName('MinHeight');
            $fields->removeByName('MaxHeight');
            $fields->removeByName('Type');

            if ($this->ID == 0){
                $fields->addFieldsToTab('Root.Main',[
                     HTMLOptionsetField::create('Type',_t(__CLASS__.'.Type','Typ'), $this->stat('block_types')),
                     LabelField::create('LabelField',_t(__CLASS__.'.SlideCopyHelpText','Speichern Sie um Slides hinzufügen oder kopieren Sie eine andere Slider'))
                 ]);

            }
            if ($this->Slides()->count() == 0){
                $referent = new GroupedDropdownField("ReferentID", _t(__CLASS__.'.CopySlides',"Slides kopieren nach"), $source = $this->getReferentSource());
                $referent->setEmptyString(_t(__CLASS__.'.CopySlidesHelpText','Bitte Slidershow auswählen'));
                $fields->addFieldToTab('Root.Main',$referent);
            }
            

            if ($this->ID > 0 && $this->ReferentID == 0){
                $config = GridFieldConfig_RecordEditor::create();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Slide')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $slidesField = new GridField('Slides',_t(__CLASS__.'.Slides','Slides'),$this->Slides(),$config);
                $fields->addFieldToTab('Root.Main',$slidesField);
            }


           
            $fields->addFieldToTab('Root.LayoutTab', CompositeField::create(
               
                HTMLOptionsetField::create('Height',_t(__CLASS__.'.Heights','Höhe'),$this->stat('block_heights')),
                HTMLOptionsetField::create('Nav',_t(__CLASS__.'.Controls','Kontrols'), $this->stat('controls'))
                )->setTitle(_t(__CLASS__.'.SlideLayout','Slide Format'))->setName('SlideLayout')
            );

            $fields->addFieldToTab('Root.LayoutTab', CompositeField::create(
                CheckboxField::create('Autoplay',_t(__CLASS__.'.Autoplay','Autoplay')),
                DropdownField::create('Animation',_t(__CLASS__.'.Animation','Animation'), $this->getTranslatedSourceFor(__CLASS__,'animations')),
                TextField::create('MinHeight',_t(__CLASS__.'.MinHeight','min. Höhe')),
                TextField::create('MaxHeight',_t(__CLASS__.'.MaxHeight','max. Höhe'))
                )->setTitle(_t(__CLASS__.'.SlideSettings','Slide Einstellungen'))->setName('SlideSettings')
            );
       
       
        $fields->removeByName('LinkableLinkID');
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Slideshow');
    }

    public function activeSlides(){
        $slides = ($this->ReferentID > 0) ? $this->Referent()->Slides() : $this->Slides();
        if (singleton('Slide')->hasExtension('Activable')){
            return $slides->filter('isVisible',1);
        }
        return $slides();
    }

    public function NiceTitle(){
        return ($this->Title) ? $this->Title : '#Slider-'.$this->ID;
    }

    public function getReferentSource(){
        $source = [];
        foreach (Page::get() as $page) {
            if (SliderBlock::get()->filter(array('ParentID' => $page->ElementalAreaID, 'ReferentID' => 0))->exclude('ID',$this->ID)->count() > 0){
                $slides = SliderBlock::get()->filter(array('ParentID' => $page->ElementalAreaID, 'ReferentID' => 0))->exclude('ID',$this->ID)->map('ID','NiceTitle')->toArray();
                $source[$page->MenuTitle] = $slides;
            }
        } 
        return $source;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if ($this->isChanged('Height')){
            switch($this->Height){
                case "small":
                    $this->MinHeight = 250;
                    $this->MaxHeight = 350;
                break;
                case "medium":
                    $this->MinHeight = 350;
                    $this->MaxHeight = 500;
                break;
                case "large":
                    $this->MinHeight = 450;
                    $this->MaxHeight = 700;
                break;
                default:
                    $this->MaxHeight = 2500;
                    $this->MinHeight =250;
                break;
            }
        }
    }

    public function ImageHeight(){
        switch($this->Height){
            case "small":
            return 350;
            break;
            case "medium":
            return 500;
            break;
            case "large":
            return 700;
            break;
        }
    }




    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('animations') as $key => $value) {
          $entities[__CLASS__.".animations_{$key}"] = $value;
        }

        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
