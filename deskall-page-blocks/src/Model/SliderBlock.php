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
use g4b0\SearchableDataObjects\Searchable;

class SliderBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-block-banner';
    
    private static $controller_template = 'ElementHolder';

    private static $controller_class = BlockController::class;

    private static $inline_editable = false;

    private static $db = [
        'Animation' => 'Varchar(255)',
        'Autoplay' => 'Boolean(1)',
        'Nav' => 'Varchar(255)',
        'Height' => 'Varchar(255)',
        'MinHeight' => 'Varchar(255)',
        'MaxHeight' => 'Varchar(255)',
        'RandomPlay' => 'Boolean(0)'
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

    

    private static $defaults = [
        'Layout' => 'slideshow',
        'FullWidth' => 1,
        'MinHeight' => '250',
        'Height' => 'viewport',
       'SectionPadding' => 'uk-padding-remove'
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

    private static $description = 'Bilder als Slide angezeigen.';

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
            $fields->removeByName('BackgroundImage');
            $fields->removeByName('Background');
            $fields->removeByName('TextLayout');
            $fields->removeByName('RandomPlay');

            if ($this->ID == 0){
                $fields->addFieldToTab('Root.Main',LabelField::create('LabelField',_t(__CLASS__.'.SlideCopyHelpText','Speichern Sie um Slides hinzufügen oder kopieren Sie eine andere Slider')));

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
                $config->addComponent(new GridFieldDuplicateAction());
                $slidesField = new GridField('Slides',_t(__CLASS__.'.Slides','Slides'),$this->Slides(),$config);
                $fields->addFieldToTab('Root.Main',$slidesField);
            }


           
            $fields->addFieldToTab('Root.LayoutTab', CompositeField::create(
          //      HTMLOptionsetField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->stat('block_layouts')),
                HTMLOptionsetField::create('Height',_t(__CLASS__.'.Heights','Höhe'),$this->stat('block_heights')),
                HTMLOptionsetField::create('Nav',_t(__CLASS__.'.Controls','Kontrols'), $this->stat('controls'))
                )->setTitle(_t(__CLASS__.'.SlideLayout','Slide Format'))->setName('SlideLayout')
            );

            $fields->addFieldToTab('Root.LayoutTab', CompositeField::create(
                CheckboxField::create('Autoplay',_t(__CLASS__.'.Autoplay','Autoplay')),
                CheckboxField::create('RandomPlay',_t(__CLASS__.'.RandomPlay','zufällige Anzeige?')),
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

    public function ActiveSlides(){
        $slides = ($this->ReferentID > 0) ? $this->Referent()->Slides()->filter('isVisible',1) : $this->Slides()->filter('isVisible',1);
        
        
        if ($this->RandomPlay){
            return $slides->sort('RAND()');
        }
        return $slides;
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
            case "viewport":
            return 1200;
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
        return array('SlideContent');
    }

    public function getSlideContent(){
        $html = '';
        if ($this->Slides()->count() > 0){
            $html .= '<ul>';
            foreach ($this->Slides() as $slide) {
                $html .= '<li>';
                if ($slide->Title){
                    $html .= $slide->Title."\n";
                }
                if ($slide->Content){
                    $html .= $slide->Content;
                }
                $html .= '</li>';
            }
            $html .='</ul>';
        }
        return $html;
    }
/************ END SEARCHABLE ***************************/
}
