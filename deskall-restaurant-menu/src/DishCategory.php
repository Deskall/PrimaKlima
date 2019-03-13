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

class DishCategory extends DataObject{

    private static $singular_name = 'Speise Sort';

    private static $plural_name = 'Speise Sorten';

    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'HTMLText'
    ];

    private static $has_one = [
    	'Image' => Image::class
    ];

    private static $has_many = [
        'Dishes' => Dish::class
    ];

    private static $owns = ['Image'];


    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    private static $summary_fields = [
        'PrintThumbnail' => ['title' => 'Bild'],
        'Title',
        'PrintDescription' => ['title' => 'Beschreibung']
    ];

    private static $searchable_fields = ['Title'];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Description'] = _t(__CLASS__.'.Description','Beschreibung');
        $labels['Image'] = _t(__CLASS__.'.Image','Bild');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        
        return $fields;
    }

    public function PrintThumbnail(){
        $html = ($this->Image()->exists()) ? $this->Image()->Thumbnail(80,80) : '(keine)';
        return DBField::create_field('HTMLText',$html);
    }

     public function PrintDescription(){
       
        return DBField::create_field('HTMLText',$this->Description);
    }
}
