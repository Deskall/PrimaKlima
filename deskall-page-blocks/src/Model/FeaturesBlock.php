<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\Config\Config;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Tab;

class FeaturesBlock extends BaseElement
{
    private static $icon = 'font-icon-block-file-list';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'IconItem' => 'Varchar(255)',
        'FeaturesTitle' => 'Varchar(255)',
        'FeaturesColumns' => 'Varchar(255)',
        'FeaturesTextAlign' => 'Varchar(255)'
    ];

    private static $has_one = [
        'ContentImage' => Image::class
    ];

    private static $has_many = [
        'Features' => Features::class
    ];

    private static $cascade_delete = [
        'Features',
    ];

    private static $cascade_duplicates = ['Features'];


    private static $owns = [
        'ContentImage',
    ];

    private static $defaults = [
        'FeaturesColumns' => 'uk-child-width-1-1',
        'FeaturesTextAlign' => 'uk-text-left',
        'IconItem' => 'check'
    ];

    private static $features_columns = [
        'uk-child-width-1-1' =>  [
            'value' => 'uk-child-width-1-1',
            'title' => '1 Spalte',
            'icon' => '/deskall-page-blocks/images/icon-text.svg'
        ],
        'uk-child-width-1-2@s' =>  [
            'value' => 'uk-child-width-1-2@s',
            'title' => '2 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-2-columns.svg'
        ],
        'uk-child-width-1-2@s uk-child-width-1-3@m' =>  [
            'value' => 'uk-child-width-1-2@s uk-child-width-1-3@m',
            'title' => '3 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-3-columns.svg'
        ],
        'uk-child-width-1-1@s uk-child-width-1-4@m' =>  [
            'value' => 'uk-child-width-1-1@s uk-child-width-1-4@m',
            'title' => '4 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-4-columns.svg'
        ],
        'uk-child-width-1-2@s uk-child-width-1-4@m uk-child-width-1-5@l' =>  [
            'value' => 'uk-child-width-1-2@s uk-child-width-1-4@m uk-child-width-1-5@l',
            'title' => '5 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-5-columns.svg'
        ]
    ];


    private static $features_text_alignments = [
        'uk-text-left' =>  [
            'value' => 'uk-text-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'uk-text-right' =>  [
            'value' => 'uk-text-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-right-align.svg'
        ],
        'uk-text-center' => [
            'value' => 'uk-text-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-center-align.svg'
        ],
        'uk-text-justify' => [
            'value' => 'uk-text-justify',
            'title' => 'Justify Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-justify-align.svg'
        ]
    ];


    private static $table_name = 'FeaturesBlock';

    private static $singular_name = 'Features block';

    private static $plural_name = 'Features blocks';

    private static $description = 'Features List';



    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

            $fields->removeByName('FeaturesColumns');
            $fields->removeByName('IconItem');
            $fields->removeByName('Layout');
            $fields->removeByName('FeaturesTextAlign');
            $fields->removeByName('Features');

            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'))
                ->setRows(5);
            $fields->fieldByName('Root.Main.ContentImage')->setFolderName($this->getFolderName());
            
            $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
                HTMLOptionsetField::create('FeaturesTextAlign',_t(__CLASS__.'.FeaturesTextAlignment','Features Textausrichtung'),$this->stat('features_text_alignments')),
                HTMLOptionsetField::create('FeaturesColumns',_t(__CLASS__.'.FeaturesInColumns','Features in mehreren Spalten'),$this->stat('features_columns')),
                HTMLDropdownField::create('IconItem',_t(__CLASS__.'.FeaturesIcons','Icon'),$this->getSourceIcons(),'check')
            )->setTitle(_t(__CLASS__.'.FeaturesLayout','Features Layout'))->setName('FeaturesLayout'));

            if ($this->ID > 0){

                $config = 
                GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Features')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $featuresField = new GridField('Features',_t(__CLASS__.'.Features','Features'),$this->Features(),$config);
                $title = $fields->fieldByName('Root.Main.FeaturesTitle');
                $title->setTitle(_t(__CLASS__ . '.FeaturesTitle', 'Features List Titel'));
                $fields->addFieldToTab('Root.Main',$title);
                $fields->addFieldToTab('Root.Main',$featuresField);
            } 
            else {
                $fields->removeByName('Features');
                $fields->removeByName('FeaturesTitle');
            }
     
       return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Features List');
    }

    public function activeFeatures(){
         if (singleton('Features')->hasExtension('Activable')){
            return $this->Features()->filter('isVisible',1);
        }
        return $this->Features();
    }

    public function getSourceIcons(){
        //To do : filter relevant icons
        return HTMLDropdownField::getSourceIcones();
    }

}
