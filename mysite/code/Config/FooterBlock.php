<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\GridField\GridField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\SiteConfig\SiteConfig;

class FooterBlock extends DataObject{
	private static $db = [
		'Title' => 'Varchar(255)',
		'Width' => 'Varchar(255)',
		'Class' => 'Varchar(255)',
		'SortOrder' => 'Int'
	];

	private static $extensions = [
		'Activable'
	];

	private static $has_one = [
		'SiteConfig' => SiteConfig::class
	];

	private static $has_many = [
		'Links' => FooterLink::class
	];

	private static $summary_fields = [
	    'Title' => 'Titel',
	    'Preview' => 'Vorschau',
	    'displayWidth' => 'Breite'
	];

	private static $default_sort = ['SortOrder'];

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


	public function displayWidth(){
		$widths = self::$widths;
		return $widths[$this->Width];
	}

    public function Preview(){
     $Preview = new DBHTMLText();
     $Preview->setValue($this->renderWith('FooterBlock_preview'));
     return $Preview;
    }

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->replaceField('Width',DropdownField::create('Width','Breite',self::$widths)->setEmptyString('Breite auswählen')->setDescription('Relative Breite im Vergleich zur Fußzeile'));
		$fields->replaceField('Class',TextField::create('Class','Extra CSS Class')->setDescription('Fügen Sie alle relevanten Klassen nur durch ein Leerzeichen getrennt'));

		$fields->removeByName('Links');
		$fields->removeByName('SortOrder');
		$fields->removeByName('SiteConfigID');
		if ($this->ID > 0){
			$LinksField = new GridField(
		        'Links',
		        'Links',
		        $this->Links(),
		        GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('SortOrder'))
		    );
		}
		else {
			$LinksField = LabelField::create('Links', 'Links können erst nach dem Speichern erstellt werden');
		}

		$fields->addFieldToTab('Root.Main',$LinksField);
		return $fields;
	}

	public function onBeforeWrite(){
		if (!$this->SiteConfigID){
			$this->SiteConfigID = SiteConfig::current_site_config()->ID;
		}
		parent::onBeforeWrite();
	}

	public function activeLinks(){
		return $this->Links()->filter('isVisible',1)->sort('SortOrder');
	}
}