<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Controllers\ContentController;

class MenuBlock extends LayoutBlock{

	private static $db = [
		'Layout' => 'Varchar(255)',
		'UseMenu' => 'Boolean(0)',
		'UseMenu1' => 'Boolean(0)',
		'UseMenu2' => 'Boolean(0)',
		'ShowSubLevels' => 'Boolean(0)',
		'ShowSubLevelsBis' => 'Int',
		'SubLevelLayout' => 'Varchar(255)'
	];

	private static $has_one = [
		'Logo' => Image::class
	];

	private static $has_many = [
		'Links' => MenuLink::class
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

	public function onAfterWrite(){
		if ($this->Logo()->ID > 0){
			$this->Logo()->publishSingle();
		}
		
		parent::onAfterWrite();
	}


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);

	 
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Title');
		$fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t(__CLASS__.'.Type','BlockTyp'),$this->getTranslatedSourceFor(__CLASS__,'block_types'))->setEmptyString(_t(__CLASS__.'.TypeLabel','Wählen Sie den Typ aus')),'Width');
		$fields->addFieldToTab('Root.LayoutTab',DropdownField::create('Layout',_t(__CLASS__.'.Layout','Ausrichtung'),$this->stat('block_layouts')),'Width');

		$fields->insertAfter(CompositeField::create(
			CheckboxField::create('UseMenu',_t(__CLASS__.'.UseMenu','Site Struktur benutzen'))->displayIf('Type')->isEqualTo('links')->end(),
			CheckboxField::create('ShowSubLevels',_t(__CLASS__.'.ShowSubLevels','Untenmenu anzeigen'))->displayIf('UseMenu')->isChecked()->end(),
			NumericField::create('ShowSubLevelsBis',_t(__CLASS__.'.ShowSubLevelsBis','Navigation Stufen'))->displayIf('ShowSubLevels')->isChecked()->end()
		),'Width');

		$fields->insertAfter(TextField::create('SubLevelLayout',_t(__CLASS__.'.SubLevelLayout','Unten Navigation Layout'))->displayIf('ShowSubLevels')->isChecked()->end(),'Layout');


		if ($linksfield = $fields->fieldByName('Root.Main.LinksField')){
			$linksfield->hideIf('UseMenu')->isChecked();
		}
		$fields->fieldByName('Root.Main.Logo')->displayIf('Type')->isEqualTo('logo');

		return $fields;
	}

	public function forTemplate(){
		$menu = ContentController::create()->getMenu(1);
		//print_r($menu);
		return $this->renderWith('Includes/MenuBlock', [
			'Menu' =>$menu,
			'Test' => 'test']);
	}

}