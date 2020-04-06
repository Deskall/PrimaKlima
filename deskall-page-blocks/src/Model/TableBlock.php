<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use g4b0\SearchableDataObjects\Searchable;
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

class TableBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-thumbnails';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'TableBlock';

    private static $singular_name = 'Tabelle block';

    private static $plural_name = 'Tabelle blocks';

    private static $description = 'Tabelle';


    private static $db = [
        'HTML' => 'HTMLText',
        'Caption' => 'Varchar',
        'MobileFormat' => 'Varchar',
        // 'NumberOfColumns' => 'Int'
    ];

    private static $has_many = [
        'Headers' => TableHeader::class,
        'Rows' => TableRow::class
    ];

    private static $owns = [
        'Headers',
        'Rows',
    ];

    private static $cascade_duplicates = ['Headers','Rows'];


    private static $mobile_formats = [
        'stack' => 'Stapel',
        'overflow' => 'horizontale Schriftrolle'
        //  '' => 'standard',
        // 'uk-table-expand'  => 'erweitern',
        // 'uk-table-shrink'   => 'schrumpfen'
    ];


/***********************************************************************/
    
    public function fieldLabels($includerelations = true ){
        $labels = parent::fieldLabels($includerelations );
        $labels['HTML'] = _t(__CLASS__.'.HTML', 'Inhalt');
        $labels['Caption'] = _t(__CLASS__.'.Caption', 'Tabelle Beschriftung');
        $labels['MobileFormat'] = _t(__CLASS__.'.MobileFormat', 'Mobile Ansicht');
        $labels['Rows'] = _t(__CLASS__.'.Rows', 'Tabelle Linien');
        $labels['Headers'] = _t(__CLASS__.'.Headers', 'Tabelle Spalten');

        return $labels;
    }
    

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Headers');
        $fields->removeByName('Rows');
      

        $fields->fieldByName('Root.Main.HTML')->setRows(5);
        // $fields->fieldByName('Root.Main.NumberOfColumns')->setMin(1)->setMax(10);
            
        // LAYOUT
        $fields->addFieldToTab('Root.LayoutTab', DropdownField::create('MobileFormat',$this->fieldLabels()['MobileFormat'], $this->getTranslatedSourceFor(__CLASS__,'mobile_formats')));

        if ($this->ID > 0){
            $config = 
            GridFieldConfig::create()
            ->addComponent(new GridFieldButtonRow('before'))
            ->addComponent(new GridFieldToolbarHeader())
            ->addComponent(new GridFieldTitleHeader())
            ->addComponent(new GridFieldEditableColumns())
            ->addComponent(new GridFieldDeleteAction())
            ->addComponent(new GridFieldAddNewInlineButton())
            ->addComponent(new GridFieldOrderableRows('Sort'))
            ->addComponent(new GridFieldShowHideAction());
            $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
                'Title' => array(
                    'title' => 'Titel',
                    'field' => TextField::class
                ),
                'Format' => array(
                    'title' => 'Breite',
                    'callback' => function ($record, $column, $grid) {
                        return DropdownField::create($column,$record->fieldLabels()['Format'],['' => 'standard','uk-table-expand'  => 'erweitern','uk-table-shrink'   => 'schrumpfen']);
                    }
                ),
                'TextAlign' => array(
                    'title' => 'Ausricthung',
                    'callback' => function ($record, $column, $grid) {
                        return HTMLOptionsetField::create($column,$this->fieldLabels()[$column],[
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
                        ]);
                    }
                )
            ));

            $headersField = new GridField('Headers',$this->fieldLabels()['Headers'],$this->Headers(),$config);

            $fields->addFieldToTab('Root.Main',$headersField);
        }

        if ($this->ID > 0 && $this->Headers()->exists()){
            $columns = [];
            foreach ($this->Headers() as $header) {
                $columns[$header->Title] = array(
                    'title' => $header->Title,
                    'field' => TextareaField::class
                );
            }
            $config2 = 
            GridFieldConfig::create()
            ->addComponent(new GridFieldButtonRow('before'))
            ->addComponent(new GridFieldToolbarHeader())
            ->addComponent(new GridFieldTitleHeader())
            ->addComponent(new GridFieldEditableColumns())
            ->addComponent(new GridFieldDeleteAction())
            ->addComponent(new GridFieldAddNewInlineButton())
            ->addComponent(new GridFieldOrderableRows('Sort'))
            ->addComponent(new GridFieldShowHideAction());
            $config2->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields($columns);

            $rowsField = new GridField('Rows',$this->fieldLabels()['Rows'],$this->Rows(),$config2);

            $fields->addFieldToTab('Root.Rows',$rowsField);

            $fields->fieldByName('Root.Rows')->setTitle($this->fieldLabels()['Rows']);
        }

        
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Tabelle');
    }

  
    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('mobile_formats') as $key => $value) {
          $entities[__CLASS__.".mobile_formats_{$key}"] = $value;
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
        return array('HTML','Caption');
    }
/************ END SEARCHABLE ***************************/
}
