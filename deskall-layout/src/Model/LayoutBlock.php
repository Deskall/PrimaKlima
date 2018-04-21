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
use UncleCheese\DisplayLogic\Forms\Wrapper;


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

	

	private static $summary_fields = [
	    'NiceType' ,
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


	public function displayWidth(){
		$widths = self::$widths;
		return $widths[$this->Width];
	}


	public function NiceTitle(){
		return ($this->Type == "adresse") ? $this->SiteConfig()->Title : $this->Title;
	}

	public function NiceType(){
		return $this->stat('block_types')[$this->Type];
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

			$fields->addFieldToTab('Root.LayoutTab', $w = DropdownField::create('Width',_t(__CLASS__.'.Width','Breite'),$this->getTranslatedSourceFor(__CLASS__,'widths'))->setEmptyString(_t(__CLASS__.'.WidthLabel','Breite auswählen'))->setDescription(_t(__CLASS__.'.WidthDescription','Relative Breite im Vergleich zur Fußzeile')));
			$fields->addFieldToTab('Root.LayoutTab', $cs = TextField::create('Class',_t(__CLASS__.'.ExtraClass','Extra CSS Class'))->setDescription(_t(__CLASS__.'.ClassDescription','Fügen Sie alle relevanten Klassen nur durch ein Leerzeichen getrennt')));
			
			$title = $fields->fieldByName('Root.Main.Title');
			$fields->removeByName('Links');
			$fields->removeByName('SiteConfigID');
			$title->displayIf('Type')->isEqualTo('links');
			if ($this->Type == "links"){
				if ($this->ID > 0){
							$LinksField = Wrapper::create(new GridField(
						        'Links',
						        _t(__CLASS__.'.Links','Links'),
						        $this->Links(),
						        GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))
						    ))->setName('LinksField');
						}
						else {
							$LinksField = Wrapper::create(
								LabelField::create('Links', _t(__CLASS__.'.LinksLabel','Links können erst nach dem Speichern erstellt werden')))->setName('LinksField');
						}

						$fields->addFieldToTab('Root.Main',$LinksField);
						$LinksField->displayIf('Type')->isEqualTo('links');
			}
			
			$fields->addFieldToTab('Root.Main', $content = TextareaField::create('Content',_t(__CLASS__.'.Content','Inhalt')),'Title');
			$content->displayIf('Type')->isEqualTo('content');

			$fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.ContentTab','Inhalt'));
			$fields->FieldByName('Root.LayoutTab')->setTitle(_t(__CLASS__.'.LayoutTab','Layout'));
		});
		return parent::getCMSFields();
	}

	public function onBeforeWrite(){
		if (!$this->SiteConfigID){
			$this->SiteConfigID = SiteConfig::current_site_config()->ID;
		}
		if ($this->Width == ""){
			$this->Width = "uk-width-auto";
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

        foreach($this->stat('backgrounds') as $key => $value) {
          $entities[__CLASS__.".backgrounds_{$key}"] = $value;
        }             
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}