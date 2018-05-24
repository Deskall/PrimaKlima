<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ListBlock extends BaseElement
{
    private static $icon = 'font-icon-plus-circled';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'ListBlock';

    private static $singular_name = 'List Block';

    private static $plural_name = 'List Blocks';

    private static $description = 'Itemlist schaffen (Links, Referenz,...)';

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
        ]
    ];

    private static $db = [
        'ItemAlign' => 'Varchar(255)',
        'Divider' => 'Boolean(1)',
         'HTML' => 'HTMLText'
    ];

    private static $has_one = [
        
    ];

    private static $has_many = [
        'Items' => ListItem::class
    ];

    private static $owns = [
       'Items'
    ];

    private static $defaults = [
       'ItemAlign' => 'left',
       'ShowBottomBorder' => 1
    ];


    private static $cascade_duplicates = [
        'Items'
    ];
 


/***********************************************************************/
    
    public function fieldLabels($includerelations = true ){
        $labels = parent::fieldLabels($includerelations );
        $labels['Items'] = _t(__CLASS__.'.ItemsLabel', 'Items');
        $labels['HTML'] = _t(__CLASS__.'.Content', 'Inhalt');

        return $labels;
    }
    

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Layout');
        $fields->removeByName('Items');
        $fields->removeByName('Divider');
        $fields->removeByName('ShowBottomBorder');
        $fields->removeByName('ItemAlign');
        $fields->FieldByName('Root.Main.HTML')->setRows(5);

        if ($this->ID > 0){

            $config = 
            GridFieldConfig_RecordEditor::create()
            ->addComponent(new GridFieldOrderableRows('Sort'));
            if (singleton('ListItem')->hasExtension('Activable')){
                 $config->addComponent(new GridFieldShowHideAction());
            }
            $itemsField = new GridField('Items',_t(__CLASS__.'.Items','Items'),$this->Items(),$config);
            $fields->addFieldToTab('Root.Main',$itemsField);
        } 
        else {
            $fields->removeByName('Items');
        }

        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            HTMLOptionsetField::create('ItemAlign',_t(__CLASS__.'.ItemAlignment','Item Layout'),$this->owner->stat('block_layouts')),
            CheckboxField::create('Divider',_t(__CLASS__.'.ShowBottomBorder','Border zwischen Item anzeigen'))
        )->setTitle(_t(__CLASS__.'.ItemLayout','List Format Optionen'))->setName('ItemLayout'));
        
 
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'List');
    }


    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        
        
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
