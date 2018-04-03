<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\SiteConfig\SiteConfig;

class LayoutBlock extends DataObject{

	private static $db = [
		'Title' => 'Text',
		'Width' => 'Varchar(255)',
		'Class' => 'Varchar(255)',
		'Type' => 'Varchar(255)',
		'Content' => 'HTMLText'
	];

	private static $extensions = [
		'Activable',
		'Sortable'
	];

	private static $has_one = [
		'SiteConfig' => SiteConfig::class
	];

	private static $has_many = [
		'Links' => LayoutLink::class
	];

	private static $summary_fields = [
	    'NiceTitle' ,
	    'Preview',
	    'displayWidth'
	];

	private static $default_sort = ['Sort'];

	private static $castings = [
	'Preview' => 'HTMLText'];

	private static $widths = [
		'uk-width-1-1@s uk-width-1-5@m' => '20%',
		'uk-width-1-1@s uk-width-1-4@m' => '25%', 
		'uk-width-1-1@s uk-width-1-3@m' => '33.33%', 
		'uk-width-1-1@s uk-width-1-2@m' => '50%',
		'uk-width-1-1' => 'Voll Breite',
		'uk-width-auto' => 'auto Breite',
		'uk-width-expand' => 'verbleibende Breite'
	];

	private static $backgrounds = [
        'uk-section-default' => 'keine Hintergrundfarbe',
        'uk-section-primary dk-text-hover-primary' => 'primäre Farbe',
        'uk-section-secondary dk-text-hover-secondary' => 'sekundäre Farbe',
        'uk-section-muted dk-text-hover-muted' => 'grau',
        'dk-background-white uk-section-default dk-text-hover-white' => 'weiss',
        'dk-background-black uk-section-default dk-text-hover-black' => 'schwarz'
    ];

	private static $block_types = [
		
	];


	public function displayWidth(){
		$widths = self::$widths;
		return $widths[$this->Width];
	}

	public function NiceTitle(){
		return ($this->Type == "adresse") ? $this->SiteConfig()->Title : $this->Title;
	}

    public function Preview(){
     $Preview = new DBHTMLText();
     $Preview->setValue($this->renderWith(__CLASS__.'_preview'));
     return $Preview;
    }

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	 
	    $labels['NiceTitle'] = _t(__CLASS__.'.TitleLabel','Titel');
	    $labels['Preview'] = _t(__CLASS__.'.Preview', 'Vorschau');
	    $labels['displayWidth'] = _t(__CLASS__.'.Width',  'Breite');
	 
	    return $labels;
	}

	public function getCMSFields(){
		$this->beforeUpdateCMSFields(function ($fields) {

			$fields->addFieldToTab('Root.Main', $w = DropdownField::create('Width',_t(__CLASS__.'.Width','Breite'),$this->getTranslatedSourceFor(__CLASS__,'widths'))->setEmptyString(_t(__CLASS__.'.WidthLabel','Breite auswählen'))->setDescription(_t(__CLASS__.'.WidthDescription','Relative Breite im Vergleich zur Fußzeile')));
			$fields->addFieldToTab('Root.Main', $cs = TextField::create('Class',_t(__CLASS__.'.ExtraClass','Extra CSS Class'))->setDescription(_t(__CLASS__.'.ClassDescription','Fügen Sie alle relevanten Klassen nur durch ein Leerzeichen getrennt')));
			$fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t(__CLASS__.'.Type','BlockTyp'),$this->getTranslatedSourceFor(__CLASS__,'block_types'))->setEmptyString(_t(__CLASS__.'.TypeLabel','Wählen Sie den Typ aus')),'Title');
			$title = $fields->fieldByName('Root.Main.Title');
			$fields->removeByName('Links');
			$fields->removeByName('SiteConfigID');
			$title->displayIf('Type')->isEqualTo('links');
			if ($this->Type == "links"){
				if ($this->ID > 0){
							$LinksField = new GridField(
						        'Links',
						        _t(__CLASS__.'.Links','Links'),
						        $this->Links(),
						        GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))
						    );
						}
						else {
							$LinksField = LabelField::create('Links', _t(__CLASS__.'.LinksLabel','Links können erst nach dem Speichern erstellt werden'));
						}

						$fields->addFieldToTab('Root.Main',$LinksField);
			}
			
				$fields->addFieldToTab('Root.Main', $content = TextareaField::create('Content',_t(__CLASS__.'.Content','Inhalt')),'Title');
			$content->displayIf('Type')->isEqualTo('content');
		});
		return parent::getCMSFields();
	}

	public function onBeforeWrite(){
		if (!$this->SiteConfigID){
			$this->SiteConfigID = SiteConfig::current_site_config()->ID;
		}
		parent::onBeforeWrite();
	}

	public function activeLinks(){
		return $this->Links()->filter('isVisible',1);
	}

	/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('widths') as $key => $value) {
          $entities[__CLASS__.".widths_{$key}"] = $value;
        }
        foreach($this->stat('block_types') as $key => $value) {
          $entities[__CLASS__.".block_types_{$key}"] = $value;
        }         
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}