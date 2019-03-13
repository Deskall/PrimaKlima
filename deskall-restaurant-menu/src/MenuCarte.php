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


class MenuCarte extends DataObject{

    private static $singular_name = 'Karte';

    private static $plural_name = 'Karte';

    private static $db = [
        'Title' => 'Varchar',
        'Date' => 'Date'
    ];


    private static $many_many = [
    	'Elements' => MenuKarteElement::class
    ];

    private static $has_one = [
        'File' => File::class
    ];

    private static $owns = [
        'File'
    ];

    private static $many_many_extraFields = [
        'Elements' => ['SortOrder' => 'Int']
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Subtitle'] = _t(__CLASS__.'.Subtitle','SubTitel');
        $labels['MenuTitle'] = _t(__CLASS__.'.MenuTitle','Menu');
        $labels['LeadText'] = _t(__CLASS__.'.LeadText','Einstiegtext');
        $labels['Intro'] = _t(__CLASS__.'.Intro','Intro');
        $labels['Target'] = _t(__CLASS__.'.Target','Zielgruppe');
        $labels['Content'] = _t(__CLASS__.'.Content','Seminarinhalte');
        $labels['Extras'] = _t(__CLASS__.'.Extras','Extras');
        $labels['Duration'] = _t(__CLASS__.'.Duration','Dauer');
        $labels['Target'] = _t(__CLASS__.'.Target','Zielgruppe');
        $labels['Investition'] = _t(__CLASS__.'.Investition','Investition');
        $labels['Footer'] = _t(__CLASS__.'.Footer','Footer');
        $labels['Files'] = _t(__CLASS__.'.Files','Dateien');
        $labels['Images'] = _t(__CLASS__.'.Images','Bilder');
        $labels['Videos'] = _t(__CLASS__.'.Videos','Videos');
     
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('URLSegment');
        $fields->removeByName('Files');
        $fields->removeByName('Images');
        $fields->removeByName('Videos');
        $fields->removeByName('Dates');

        $fields->addFieldsToTab('Root.Files',[
        	SortableUploadField::create('Files',$this->fieldLabels()['Files'])->setIsMultiUpload(true)->setFolderName($this->getFolderName()),
        	SortableUploadField::create('Images',$this->fieldLabels()['Images'])->setIsMultiUpload(true)->setFolderName($this->getFolderName())
        ]);

		$config = GridFieldConfig_RelationEditor::create();
		$config->addComponent(new GridFieldOrderableRows('Sort'));
		$config->addComponent(new GridFieldShowHideAction());
		$videosField = new GridField('Videos',_t(__CLASS__.'.Videos','Videos'),$this->Videos(),$config);
		$fields->addFieldToTab('Root.Files',$videosField);
		$fields->fieldByName('Root.Files')->setTitle('Datei');

        $dateconfig = GridFieldConfig_RecordEditor::create();
        $dateconfig->addComponent(new GridFieldOrderableRows('Sort'));
        $dateconfig->addComponent(new GridFieldShowHideAction());
        $dateconfig->addComponent(new GridFieldDuplicateAction());
        $datesField = new GridField('Dates',_t(__CLASS__.'.Dates','Termine'),$this->Dates(),$dateconfig);
        $fields->addFieldToTab('Root.Dates',$datesField);
        $fields->fieldByName('Root.Dates')->setTitle('Termine');
        
        return $fields;
    }

    public function getFolderName(){
        return "Uploads/Menu/".$this->URLSegment;
    }

    public function Link(){
        return 'menus/aktuelles/'.$this->URLSegment;
    }


    public function ActiveElements(){
        return $this->Elements()->filter('isVisible',1);
    }


}
