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
use g4b0\SearchableDataObjects\Searchable;

class DesignBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-picture';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'DesignBlock';

    private static $singular_name = 'Design block';

    private static $plural_name = 'Design blocks';

    private static $description = 'Inhalt Block mit höher Design';


    private static $db = [
        'HTML' => 'HTMLText'
        
    ];

    private static $has_many = [
        'Resources' => GrafikElement::class
    ];



    private static $cascade_duplicates = [];





/***********************************************************************/
    
    public function fieldLabels($includerelations = true ){
        $labels = parent::fieldLabels($includerelations );
        $labels['Trigger'] = _t(__CLASS__.'.TriggeringText', 'Text der Öffnen-Button');

        return $labels;
    }
    

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Resources');
       if ($this->ID > 0 ){
            $config = GridFieldConfig_RecordEditor::create();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            if (singleton('GrafikElement')->hasExtension('Activable')){
                 $config->addComponent(new GridFieldShowHideAction());
            }
            $slidesField = new GridField('Resources',_t(__CLASS__.'.Resources','Grafik Elemente'),$this->Resources(),$config);
            $fields->addFieldToTab('Root.Main',$slidesField);
        }
      

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Block mit Design Element');
    }

   

    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_actions') as $key => $value) {
          $entities[__CLASS__.".block_actions_{$key}"] = $value;
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
        return array('HTML');
    }
/************ END SEARCHABLE ***************************/
}
