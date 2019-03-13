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
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class Dish extends DataObject{

    private static $singular_name = 'Speise';

    private static $plural_name = 'Speisen';

    private static $db = [
        'Title' => 'Text',
        'Description' => 'HTMLText',
        'Price' => 'Currency'
    ];

    private static $has_one = [
    	'Image' => Image::class,
        'MainDish' => Dish::class,
        'Category' => DishCategory::class
    ];

    private static $has_many = [
        'Subdishes' => Dish::class
    ];

    private static $owns = ['Image','Subdishes'];


    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    private static $summary_fields = [
        'PrintThumbnail' => ['title' => 'Bild'],
        'Title',
        'Description',
        'PrintPrice'  => ['title' => 'Preis']
    ];

    private static $searchable_fields = ['Title'];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Description'] = _t(__CLASS__.'.Description','Beschreibung');
        $labels['Price'] = _t(__CLASS__.'.Price','Preis');
        $labels['Image'] = _t(__CLASS__.'.Image','Bild');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('MainDishID');
        
        return $fields;
    }

    public function PrintPrice(){
        setlocale(LC_MONETARY, 'ch_CH');
        return DBField::create_field('Varchar',money_format('%i',$this->Price));
    }

    public function PrintThumbnail(){
        $html = ($this->Image()->exists()) ? $this->Image()->Thumbnail(80,80) : '(keine)';
        return DBField::create_field('HTMLText',$html);
    }
}
