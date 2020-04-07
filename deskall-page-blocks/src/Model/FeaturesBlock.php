<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LabelField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Core\Config\Config;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Tab;
use g4b0\SearchableDataObjects\Searchable;

class FeaturesBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-block-file-list';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'IconItem' => 'Varchar(255)',
        'FeaturesTitle' => 'Varchar(255)',
        'FeaturesColumns' => 'Varchar(255)',
        'FeaturesTextAlign' => 'Varchar(255)',
        'FeaturesTextBig' => 'Boolean(0)'
    ];


    private static $has_many = [
        'Features' => Features::class
    ];

    private static $cascade_delete = [
        'Features',
    ];

    private static $cascade_duplicates = ['Features'];

    private static $extensions = [
        'CollapsableTextExtension'
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
        'uk-flex-left uk-text-left' =>  [
            'value' => 'uk-flex-left uk-text-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'uk-flex-right uk-text-right' =>  [
            'value' => 'uk-flex-right uk-text-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-right-align.svg'
        ],
        'uk-flex-center uk-text-center' => [
            'value' => 'uk-flex-center uk-text-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-center-align.svg'
        ]
    ];

    private static $block_layouts = [
        'left' => [
            'value' => 'left',
            'title' => 'Links',
            'icon' => '/deskall-page-blocks/images/icon-text-left.svg'
        ],
        'right' => [
            'value' => 'right',
            'title' => 'Rechts',
            'icon' => '/deskall-page-blocks/images/icon-text-right.svg'
        ],
        'under' => [
            'value' => 'under',
            'title' => 'Unten',
            'icon' => '/deskall-page-blocks/images/icon-text-under.svg'
        ],
        'above' => [
            'value' => 'above',
            'title' => 'Oben',
            'icon' => '/deskall-page-blocks/images/icon-text-above.svg'
        ],
    ];


    private static $table_name = 'FeaturesBlock';

    private static $singular_name = 'Features block';

    private static $plural_name = 'Features blocks';

    private static $description = 'Features List';



    public function getCMSFields()
    {
        
        $this->beforeUpdateCMSFields(function($fields) {
            $fields->removeByName('FeaturesColumns');
            $fields->removeByName('IconItem');
            $fields->removeByName('Layout');
            $fields->removeByName('FeaturesTextAlign');
            $fields->removeByName('Features');
            $fields->removeByName('FeaturesTextBig');

            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'))
                ->setRows(5);

           

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
                // $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(
                //     [
                //         'Text' => [
                //             'title' => 'Feature',
                //             'callback' => function($record, $column, $grid) {
                //                 return HTMLEditorField::create($column)->setRows(2);
                //             }
                //         ]
                //     ]
                // );
                $featuresField = new GridField('Features',_t(__CLASS__.'.Features','Features'),$this->Features(),$config);
                $featuresField->addExtraClass('fluent__localised-field');
                $title = $fields->fieldByName('Root.Main.FeaturesTitle');
                $title->setTitle(_t(__CLASS__ . '.FeaturesTitle', 'Features List Titel'));
                $fields->addFieldToTab('Root.Main',$title);
                $fields->addFieldToTab('Root.Main',$featuresField);
            } 
            else {
                $fields->addFieldToTab("Root.Main",LabelField::create('LabelField',_t(__CLASS__.'.AfterCreation','Sie können Features nach dem Erstellen dem Block hinzufügen')));
        
                $fields->removeByName('Features');
                $fields->removeByName('FeaturesTitle');
            }
        });

        $fields = parent::getCMSFields();
        $fields->fieldByName('Root.LayoutTab.TextLayout')->push(HTMLOptionsetField::create('Layout',_t(__CLASS__.'.Format','Text und Bild Position'), $this->stat('block_layouts')));
        
        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            CheckboxField::create('FeaturesTextBig',_t(__CLASS__.'.FeaturesTextBig','Features mit grössere Schrift?')),
            HTMLOptionsetField::create('FeaturesTextAlign',_t(__CLASS__.'.FeaturesTextAlignment','Features Textausrichtung'),$this->stat('features_text_alignments')),
            HTMLOptionsetField::create('FeaturesColumns',_t(__CLASS__.'.FeaturesInColumns','Features in mehreren Spalten'),$this->stat('features_columns')),
            HTMLDropdownField::create('IconItem',_t(__CLASS__.'.FeaturesIcons','Icon'),$this->getSourceIcons(),'check')
        )->setTitle(_t(__CLASS__.'.FeaturesLayout','Features Layout'))->setName('FeaturesLayout'));
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
            return array('Title','FeaturesTitle');
        }

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML','FeaturesContent');
        }

        public function getFeaturesContent(){
            $html = '';
            if ($this->Features()->filter('isVisible',1)->count() > 0){
                $html .= '<ul>';
                foreach ($this->Features()->filter('isVisible',1) as $feature) {
                    if ($feature->Text){
                        $html .= '<li>'.$feature->Text.'</li>';
                    }
                }
                $html .='</ul>';
            }
            return $html;
        }
    /************ END SEARCHABLE ***************************/

}
