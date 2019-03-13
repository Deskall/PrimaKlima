<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\View\Parsers\URLSegmentFilter;


class Menu extends DataObject{

    private static $singular_name = 'Menü';

    private static $plural_name = 'Menü';

    private static $db = [
        'Title' => 'Varchar',
        'Price' => 'Currency'
    ];


    private static $many_many = [
    	'Dishes' => Dish::class
    ];

    private static $owns = ['Dishes'];

    private static $many_many_extraFields = [
        'Dishes' => ['SortOrder' => 'Int']
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Price'] = _t(__CLASS__.'.Price','Preis');
        $labels['Dishes'] = _t(__CLASS__.'.Dishes','Speisen');
       
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Dishes');
		$config = GridFieldConfig_RelationEditor::create();
		$config->addComponent(new GridFieldOrderableRows('Sort'));
		$config->addComponent(new GridFieldShowHideAction());
		$dishesField = new GridField('Dishes',_t(__CLASS__.'.Dishes','Speisen'),$this->Dishes(),$config);
		$fields->addFieldToTab('Root.Main',$dishesField);

       
        
        return $fields;
    }


    public function ActiveDishes(){
        return $this->Dishes()->filter('isVisible',1);
    }


}
