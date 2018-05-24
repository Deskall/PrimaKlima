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

class ListBlock extends BaseElement
{
    private static $icon = 'font-icon-plus-circled';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'ListBlock';

    private static $singular_name = 'List Block';

    private static $plural_name = 'List Blocks';

    private static $description = 'Itemlist schaffen (Links, Referenz,...)';


    private static $db = [
        
    ];

    private static $has_one = [
        
    ];

    private static $owns = [
       
    ];

    private static $defaults = [
       
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
 
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Aktion');
    }


    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        
        
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
