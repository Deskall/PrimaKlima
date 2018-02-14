<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
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
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'Animation' => 'Varchar(255)',
        'Autoplay' => 'Boolean(1)',
        'Nav' => 'Varchar(255)',
    ];

    private static $has_many = [
        'Slides' => Slide::class
    ];

    private static $owns = [
        'Slides',
    ];

    private static $defaults = [
        'Layout' => 'slideshow',
    ];

    private static $block_layouts = [
        'slideshow' => 'Slideshow'
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
            // $config = GridFieldConfig::create();
            // $config->addComponent(new GridFieldButtonRow('before'))
            //     ->addComponent(new GridFieldOrderableRows('Sort'))
            //     ->addComponent(new GridFieldDeleteAction(false))
            //     ->addComponent(new GridFieldEditableColumns())
            //     ->addComponent(new GridFieldAddNewInlineButton());
            // $displayFields = [
            //     'Title'  => function($record, $column, $grid) {
            //         return new TextField($column);
            //     },
            //     'Image' => function($record, $column, $grid) {
            //         return new UploadField($column);
            //     },
            // ];
            // $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields($displayFields);
            if ($this->ID > 0){
                $config = GridFieldConfig_RecordEditor::create();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Slide')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $slidesField = new GridField('Slides','Slides',$this->Slides(),$config);
                $fields->addFieldToTab('Root.Main',$slidesField);
            }

            $fields->addFieldToTab('Root.Settings',CheckboxField::create('Autoplay','Autoplay'));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('Animation','Animation', self::$animations));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('Nav','Kontrols', self::$controls));
            $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout','Format', self::$block_layouts));
        });
        $fields = parent::getCMSFields();
        $fields->removeByName('Background');
        $fields->removeByName('BackgroundImage');
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
        if (singleton('Slide')->hasExtension('Activable')){
            return $this->Slides()->filter('isVisible',1);
        }
        return $this->Slides();
    }

}
