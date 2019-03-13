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
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\AssetAdmin\Forms\UploadField;

class MenuCarte extends DataObject{

    private static $singular_name = 'Karte';

    private static $plural_name = 'Karte';

    private static $db = [
        'Title' => 'Varchar',
        'Date' => 'Date'
    ];


    private static $has_many = [
    	'Elements' => MenuCarteElement::class
    ];

    private static $has_one = [
        'File' => File::class
    ];

    private static $owns = [
        'File'
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Date'] = _t(__CLASS__.'.Date','Datum');
        $labels['Elements'] = _t(__CLASS__.'.Elements','Menü Items');
        $labels['File'] = _t(__CLASS__.'.File','Menü Datei (PDF)');
       
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Elements');
        $fields->removeByName('File');
        $fields->addFieldToTab('Root.Main',UploadField::create('File',$this->fieldLabels()['File'])->setFolderName($this->getFolderName()));
        if ($this->ID > 0){
            $config = GridFieldConfig_RecordEditor::create();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
            $config->addComponent(new GridFieldShowHideAction());
            $itemsField = new GridField('Elements',_t(__CLASS__.'.Elements','Elements'),$this->Elements(),$config);
            $fields->addFieldToTab('Root.Main',$itemsField);
        }
		

        return $fields;
    }

    public function getFolderName(){
        return "Uploads/Menu";
    }


    public function ActiveElements(){
        return $this->Elements()->filter('isVisible',1);
    }


}
