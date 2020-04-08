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
use SilverStripe\Control\Director;
use SilverStripe\i18n\i18n;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\RequiredFields;

class Event extends DataObject{

    private static $singular_name = 'Seminar';

    private static $plural_name = 'Seminare';

    private static $db = [
        'Title' => 'Varchar',
        'Subtitle' => 'Text',
        'MenuTitle' => 'Varchar',
        'Description' => 'HTMLText',
        'Content' => 'HTMLText',
        'URLSegment' => 'Varchar',
        'Time' => 'Varchar',
        'Target' => 'HTMLText',
        'Duration' => 'Varchar',
        'Investition' => 'HTMLText',
        'Footer' => 'HTMLText'
    ];

    private static $has_one = [
    	'Category' => EventCategory::class
    ];

    private static $has_many = [
    	'Dates' => EventDate::class
    ];

    private static $many_many = [
        'Files' => File::class,
        'Images' => Image::class,
        'Videos' => VideoObject::class
    ];

    private static $many_many_extraFields = [
        'Images' => ['SortOrder' => 'Int'],
        'Files' => ['SortOrder' => 'Int'],
        'Videos' => ['SortOrder' => 'Int']
    ];

    private static $extensions = [
        Versioned::class,
        'Activable',
        'Sortable'
    ];

    private static $owns = [
        'Files','Images','Videos','Dates'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Subtitle'] = _t(__CLASS__.'.Subtitle','SubTitel');
        $labels['MenuTitle'] = _t(__CLASS__.'.MenuTitle','Menu');
        $labels['Description'] = _t(__CLASS__.'.Description','Beschreibung');
        $labels['Content'] = _t(__CLASS__.'.Content','Inhalt');
        $labels['Target'] = _t(__CLASS__.'.Target','Zielgruppe');
        $labels['Time'] = _t(__CLASS__.'.Time','Zeit');
        $labels['Duration'] = _t(__CLASS__.'.Duration','Dauer');
        $labels['Investition'] = _t(__CLASS__.'.Investition','Preise');
        $labels['Footer'] = _t(__CLASS__.'.Footer','Extra Text');
        $labels['Files'] = _t(__CLASS__.'.Files','Dateien');
        $labels['Images'] = _t(__CLASS__.'.Images','Bilder');
        $labels['Videos'] = _t(__CLASS__.'.Videos','Videos');
     
        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->MenuTitle);
    }

    public function HeaderSlide(){
        return $this->getEventConfig()->MainPage()->HeaderSlide();
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('URLSegment');
        $fields->removeByName('Files');
        $fields->removeByName('Images');
        $fields->removeByName('Videos');
        $fields->removeByName('Dates');
        $fields->removeByName('CategoryID');

        $fields->fieldByName('Root.Main.Description')->setRows(3);

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

    public function getCMSValidator(){
        return new RequiredFields(
        'Title',
        'MenuTitle',
        'Description'
        );
    }

    public function getEventConfig(){
        return EventConfig::get()->last();
    }


    public function getFolderName(){
        return "Uploads/Kurse/".$this->URLSegment;
    }

    public function Link(){
        return $this->getEventConfig()->MainPage()->Link().'offene-kurse/'.$this->URLSegment;
    }

    public function ActiveVideos(){
        return $this->Videos()->filter('isVisible',1);
    }

    public function ActiveDates(){
        return $this->Dates()->filter('isVisible',1);
    }

    public function EventMetaTags(){
        $tags = '';
        $siteConfig = SiteConfig::current_site_config();
        
        //Metatags
        $tags .= '<meta name="description" content="'.strip_tags($this->Description).'">';

        // facebook OpenGraph
        $tags .= '<meta property="og:locale" content="' . i18n::get_locale() . '" />' . "\n";
        $tags .= '<meta property="og:title" content="' . $this->Title . '" />' . "\n";
        $tags .= '<meta property="og:description" content="' . strip_tags($this->Description) . '" />' . "\n";
        $tags .= '<meta property="og:url" content=" ' . rtrim(Director::AbsoluteUrl($this->Link()),'/'). ' " />' . "\n";
        $tags .= '<meta property="og:site_name" content="' . $siteConfig->Title . '" />' . "\n";
        $tags .= '<meta property="og:type" content="website" />' . "\n";
        
        $imageurl = ($this->Images()->first()) ? $this->Images()->first()->FocusFill(600,300)->getURL() : ( ($siteConfig->OpenGraphDefaultImage()->exists()) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,300)->getURL() : null);
        if ($imageurl){
            $tags .= '<meta property="og:image:width" content="600" />' . "\n";
            $tags .= '<meta property="og:image:height" content="300" />' . "\n";
            $tags .= '<meta property="og:image" content="'.Director::absoluteBaseURL().ltrim( $imageurl,"/").'" />' . "\n";
        }
        $tags .= $siteConfig->GoogleWebmasterMetaTag . "\n";

        return DBField::create_field('HTMLText',$tags);
    }

    public function EventStructuredData(){
        $html = '<script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Course",
          "name": "'.$this->Title.'",
          "description": "'.strip_tags($this->Description).'",
          "provider": {
            "@type": "Organization",
            "name": "Schneider Hotelgastro Consulting",
            "sameAs": "'.Director::AbsoluteBaseURL().'"
          }
        }
        </script>';
        return DBField::create_field('HTMLText',$html);
    }


}
