<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Assets\Image;

class MenuBlock extends LayoutBlock{

	private static $db = [
		'Layout' => 'Varchar(255)'
	];

	private static $has_one = [
		'Logo' => Image::class
	];

	private static $block_types = [
		'links' => 'Links',
		'logo' => 'Logo',
		'form' => 'Formular'
	];

	private static $block_layouts = [
		'uk-navbar-left' => 'uk-navbar-left',
		'uk-navbar-center' => 'uk-navbar-center',
		'uk-navbar-right' => 'uk-navbar-right'
	];



	public function NiceTitle(){
		return parent::NiceTitle();
	}


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);

	 
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Title');
		$fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t(__CLASS__.'.Type','BlockTyp'),$this->getTranslatedSourceFor(__CLASS__,'block_types'))->setEmptyString(_t(__CLASS__.'.TypeLabel','Wählen Sie den Typ aus')),'Width');
		$fields->addFieldToTab('Root.Main',DropdownField::create('Layout',_t(__CLASS__.'.Layout','Ausrichtung'),$this->stat('block_layouts')),'Width');

		$fields->insertAfter(CheckboxField::create('UseMenu',_t(__CLASS__.'.UseMenu','Site Struktur benutzen')),'Width');

		$fields->fieldByName('Root.Main.LinksField')->hideIf('UseMenu')->isChecked();
		$fields->fieldByName('Root.Main.Logo')->displayIf('Type')->isEqualTo('logo');

		return $fields;
	}

	public function forTemplate(){
		return $this->renderWith('Includes/MenuBlock');
	}

}