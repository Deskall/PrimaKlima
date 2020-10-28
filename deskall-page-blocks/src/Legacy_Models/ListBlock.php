<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\LabelField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use g4b0\SearchableDataObjects\Searchable;

class ListBlock extends BaseElement implements Searchable
{
    private static $inline_editable = false;
    
    private static $icon = 'font-icon-list';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'ListBlock';

    private static $singular_name = 'List Block';

    private static $plural_name = 'List Blocks';

    private static $description = 'Itemlist schaffen (Links, Referenz,...)';

    private static $db = [
        'Divider' => 'Boolean(1)',
        'HTML' => 'HTMLText',
        'Collapsible' => 'Boolean(0)',
        'MultipleCollapse' => 'Boolean(0)'
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
       'Divider' => 1
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
        $fields->removeByName('Collapsible'); 
        $fields->removeByName('MultipleCollapse'); 
        $fields->FieldByName('Root.Main.HTML')->setRows(5);

        if ($this->ID > 0){

            $config = 
            GridFieldConfig_RecordEditor::create()
            ->addComponent(new GridFieldOrderableRows('Sort'));
            if ($this->Collapsible){
                $config->addComponent(new GridFieldCollapseUncollapseAction());
            }
            if (singleton('ListItem')->hasExtension('Activable')){
                 $config->addComponent(new GridFieldShowHideAction());
            }
            $itemsField = new GridField('Items',_t(__CLASS__.'.Items','Items'),$this->Items(),$config);
            $fields->addFieldToTab('Root.Main',$itemsField);
        } 
        else {
            $fields->removeByName('Items');
            $fields->addFieldToTab("Root.Main",LabelField::create('LabelField',_t(__CLASS__.'.AfterCreation','Sie können Artikeln nach dem Erstellen der Liste hinzufügen')));
        }

        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            CheckboxField::create('Divider',_t(__CLASS__.'.ShowBottomBorder','Border zwischen Item anzeigen')),
            $collapse = CheckboxField::create('Collapsible',_t('ParentBlock.CollapsableChildren','zusammenklappbar Blöcke')),
            CheckboxField::create('MultipleCollapse',_t('ParentBlock.CollapseMultipe','Mehrere erweiterten Blöcke erlaubt.'))->displayIf('Collapsible')->isChecked()->end()
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
        return array('HTML','ItemContent');
    }

    public function getItemContent(){
        $html = '';
        if ($this->Items()->filter('isVisible',1)->count() > 0){
            $html .= '<ul>';
            foreach ($this->Items()->filter('isVisible',1) as $item) {
                $html .= '<li>';
                if ($item->Title){
                    $html .= $item->Title."\n";
                }
                if ($item->Content){
                    $html .= $item->Content;
                }
                $html .= '</li>';
            }
            $html .='</ul>';
        }
        return $html;
    }
/************ END SEARCHABLE ***************************/
}
