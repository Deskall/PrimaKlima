<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LabelField;
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
        'Animation' => 'Varchar(255)',
        'Autoplay' => 'Boolean(1)',
        'Nav' => 'Varchar(255)',
        'Height' => 'Varchar(255)',
        'MinHeight' => 'Int',
        'MaxHeight' => 'Int'
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
        'Height' => '4:1'
    ];

    private static $block_layouts = [
        'slideshow' => 'Slideshow'
    ];


    private static $block_heights = [
        'small' => 'klein',
        'medium' => 'medium',
        'large' => 'gross',
        'viewport' => 'ganz Bildschirm'
    ];

    private static $animations = [
        'slide' => 'slide',
        'fade' => 'fade',
        'scale' => 'scale',
        'pull' => 'pull',
        'push' => 'push'
    ];
   
    private static $controls = [
        'none' => 'kein',
        'dots' => 'dots',
        'controls' => 'arrows'
    ];

    private static $table_name = 'SliderBlock';

    private static $singular_name = 'Slideshow';

    private static $plural_name = 'Slideshow';

    private static $description = 'Bilder als Slide angezeigen.';

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('TitleAndDisplayed');
            $fields->removeByName('RelatedPageID');
            $fields->removeByName('Slides');
            $fields->removeByName('CallToActionLink');
            $fields->removeByName('ReferentID');
            if ($this->ID == 0){
                $fields->addFieldToTab('Root.Main',LabelField::create('LabelField','Speichern Sie um Slides hinzufügen oder kopieren Sie eine andere Slider'));

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

            $fields->addFieldToTab('Root.Settings',CheckboxField::create('Autoplay',_t(__CLASS__.'.Autoplay','Autoplay')));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('Animation',_t(__CLASS__.'.Animation','Animation'), $this->getTranslatedSourceFor(__CLASS__,'animations')));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('Nav',_t(__CLASS__.'.Controls','Kontrols'), $this->getTranslatedSourceFor(__CLASS__,'controls')));
            $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')));
            $fields->addFieldToTab('Root.Settings',LayoutField::create('Height',_t(__CLASS__.'.Heights','Höhe'),$this->getTranslatedSourceFor(__CLASS__,'block_heights')));
            $fields->addFieldToTab('Root.Settings',NumericField::create('MinHeight',_t(__CLASS__.'.MinHeight','min. Höhe')));
            $fields->addFieldToTab('Root.Settings',NumericField::create('MaxHeight',_t(__CLASS__.'.MaxHeight','max. Höhe')));
        });
        $fields = parent::getCMSFields();
        $fields->removeByName('Background');
        $fields->removeByName('BackgroundImage');
        $fields->removeByName('MinHeight');
            $fields->removeByName('MaxHeight');
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
                    $this->MinHeight =250;
                break;
            }
        }
    }




    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
        foreach($this->stat('block_heights') as $key => $value) {
          $entities[__CLASS__.".block_heights_{$key}"] = $value;
        }
        foreach($this->stat('animations') as $key => $value) {
          $entities[__CLASS__.".animations_{$key}"] = $value;
        }
        foreach($this->stat('controls') as $key => $value) {
          $entities[__CLASS__.".controls_{$key}"] = $value;
        }
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
