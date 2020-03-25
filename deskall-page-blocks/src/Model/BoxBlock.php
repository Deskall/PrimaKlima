<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
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
use SilverStripe\Forms\Tab;
use g4b0\SearchableDataObjects\Searchable;

class BoxBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-block-layout';

    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'BoxPerLine' => 'Varchar(255)',
        'Effect' => 'Varchar(255)',
        'BoxTextAlign' => 'Varchar(255)',
        'PictureWidth' => 'Int',
        'PictureHeight' => 'Int',
        'FullLink' => 'Boolean(0)',
        'RoundedImage' => 'Boolean(0)'
    ];

    private static $has_many = [
        'Boxes' => Box::class
    ];

    private static $owns = [
        'Boxes',
    ];

    private static $cascade_deletes = [
        'Boxes',
    ];

    private static $cascade_duplicates = ['Boxes'];

    private static $defaults = [
        'Layout' => 'standard',
        'Effect' => 'none',
        'BoxPerLine' => 'uk-child-width-1-3@s'
    ];

    private static $block_layouts = [
        'standard' => [
            'value' => 'standard',
            'title' => 'Titel, Bild, Inhalt',
            'icon' => '/deskall-page-blocks/images/icon-box-standard.svg'
        ],
        'mixed' => [
            'value' => 'mixed',
            'title' => 'Bild, Titel, Inhalt',
            'icon' => '/deskall-page-blocks/images/icon-box-mixed.svg'
        ],
        'inversed' => [
            'value' => 'inversed',
            'title' => 'Titel,Inhalt,Bild',
            'icon' => '/deskall-page-blocks/images/icon-box-inversed.svg'
        ]
    ];

    private static $effects = [
        'none' => 'kein',
        'double' => 'Zweiten Bild anzeigen',
        'scale' => 'Bild grossieren',
        'cta' => 'CallToAction anzeigen',
    ];

    private static $boxes_per_line = [
        'uk-child-width-1-2@s' => [
            'value' => 'uk-child-width-1-2@s',
            'title' => '2',
            'icon' => '/deskall-page-blocks/images/icon-box-2.svg'
        ],
        'uk-child-width-1-3@s' => [
            'value' => 'uk-child-width-1-3@s',
            'title' => '3',
            'icon' => '/deskall-page-blocks/images/icon-box-3.svg'
        ],
        'uk-child-width-1-2@s uk-child-width-1-4@m' => [
            'value' => 'uk-child-width-1-2@s uk-child-width-1-4@m',
            'title' => '4',
            'icon' => '/deskall-page-blocks/images/icon-box-4.svg'
        ]
    ];

    private static $boxes_text_alignments = [
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


    private static $table_name = 'BoxBlock';

    private static $singular_name = 'Boxen Block';

    private static $plural_name = 'Boxen Blöcke';

    private static $description = 'mehrere Inhalt Boxen per Linie';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
          
            $fields->removeByName('Boxes');
            $fields->removeByName('PictureHeight');
            $fields->removeByName('PictureWidth');
            $fields->removeByName('BoxTextAlign');
            $fields->removeByName('BoxPerLine');
            $fields->removeByName('Effect');
            $fields->removeByName('Layout');
            $fields->removeByName('FullLink');
            $fields->removeByName('RoundedImage');

            $fields->FieldByName('Root.Main.HTML')->setRows(5);
                
            if ($this->ID > 0){
                $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
                HTMLOptionsetField::create('Layout',_t(__CLASS__.'.BoxTemplate','Box Inhalt Position'), $this->stat('block_layouts')),
                HTMLOptionsetField::create('BoxTextAlign',_t(__CLASS__.'.BoxTextAlignment','Boxen Textausrichtung'),$this->stat('boxes_text_alignments')),
                HTMLOptionsetField::create('BoxPerLine',_t(__CLASS__.'.BoxPerLine','Boxen per Linie'), $this->stat('boxes_per_line')),
                DropdownField::create('Effect',_t(__CLASS__.'.Effect','Effekt auf Mouseover'), $this->getTranslatedSourceFor(__CLASS__,'effects')),
                CheckboxField::create('FullLink',_t(__CLASS__.'.FullLink','ganze Box anklickbar?')),
                CheckboxField::create('RoundedImage',_t(__CLASS__.'.RoundedImage','Rund Bilder?'))
                )->setTitle(_t(__CLASS__.'.BoxFormat','Boxen Format'))->setName('BoxLayout'));
                
                $config = GridFieldConfig_RecordEditor::create();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Box')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $boxesField = new GridField('Boxes',_t(__CLASS__.'.Boxes','Boxen'),$this->Boxes(),$config);
                $fields->addFieldToTab('Root.Main',$boxesField);
            }
       
        

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Boxen');
    }

    public function activeBoxes(){
        if (singleton('Box')->hasExtension('Activable')){
            return $this->Boxes()->filter('isVisible',1);
        }
        return $this->Boxes();
    }


    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $widthF = 2500;
        $widthN = 1200;
        $padding = 30; //must be the same as less global-gutter variable
        $ratio = 1.4; 
        $width = ($this->FullWidth) ? $widthF / static::$boxes_per_line[$this->BoxPerLine]['title'] : $widthN /  static::$boxes_per_line[$this->BoxPerLine]['title'];
        $height = $width / $ratio;

        $this->PictureWidth = $width - $padding;
        $this->PictureHeight = $height;
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        foreach($this->stat('effects') as $key => $value) {
          $entities[__CLASS__.".effects_{$key}"] = $value;
        }
       

       
        return $entities;
    }
/************* END TRANLSATIONS *******************/

/************* SEARCHABLE FUNCTIONS ******************/

    public function getBoxesHTML(){
        $html = '';
        if ($this->Boxes()->filter('isVisible',1)->count() > 0){
            $html .= '<ul>';
            foreach ($this->Boxes()->filter('isVisible',1) as $box) {
                if ($box->Content){
                    $html .= '<li>'.$box->Content.'</li>';
                }
            }
        }
       
        return $html;
    }


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
            return array('HTML', 'BoxesHTML');
        }
    /************ END SEARCHABLE ***************************/
}
