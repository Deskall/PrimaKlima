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


class MenuCarteElement extends DataObject{

    private static $singular_name = 'Karte Item';

    private static $plural_name = 'Karte Items';

    private static $db = [
        'Type' => 'Varchar',
        'Title' => 'Varchar'
        'Content' => 'HTMLText'
    ];

    private static $has_one = [
        'Karte' => MenuCarte::class,
        'Menu' => Menu::class,
        'Dish' => Dish::class
    ];

   
    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Type'] = _t(__CLASS__.'.Type','Typ');
        $labels['Content'] = _t(__CLASS__.'.Content','Inhalt');
        $labels['Karte'] = _t(__CLASS__.'.Karte','Karte');
        $labels['Menu'] = _t(__CLASS__.'.Menu','Menü');
        $labels['Dish'] = _t(__CLASS__.'.Dish','Speise');
     
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Type');

        $fields->insertBefore('Title',DropdownField::create('Type',$this->fieldLabels()['Type'],['menu' => 'Menü','dish' => 'Speise','element' => 'Inhalt'])->setEmptyString('Bitte wählen'));

        $fields->FieldByName('Root.DishID')->displayIf('Type')->isEqualTo('dish');
        $fields->FieldByName('Root.MenuID')->displayIf('Type')->isEqualTo('menu');
        $fields->FieldByName('Root.Title')->displayIf('Type')->isEqualTo('element');
        $fields->FieldByName('Root.Content')->displayIf('Type')->isEqualTo('element');
        
        return $fields;
    }



}
