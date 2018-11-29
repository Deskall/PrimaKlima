<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\TextField;
use SilverStripe\Assets\Image;
use SilverStripe\CMS\Controllers\ContentController;

class MobileMenuBlock extends MenuBlock{

	private static $db = [
	];

	private static $defaults = ['isMobile' => 1];

	

	private static $block_types = [
		'content' => 'Inhalt',
		'social' => 'Sozial Netwerke',
		'divider' => 'Teiler'
	];

	private static $menu_options = [
		
	];

	private static $block_layouts = [
		
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

		$fields->fieldByName('Root.Main.Type')->setSource($this->getTranslatedSourceFor(__CLASS__,'block_types'));
		$fields->removeByName('UseMenuOption');
		$fields->removeByName('LayoutTab');
		$fields->insertAfter(TextField::create('Title',_t(__CLASS__.'.Title','Titel'))
			->displayIf('Type')->isEqualTo('content')
			->andIf('Type')->isEqualTo('address')
			->end(),'Type');
		return $fields;
	}

	// public function forTemplate(){
	// 	$menu = ContentController::create()->getMenu(1);
	// 	return $this->renderWith('Includes/MobileMenuBlock', [
	// 		'Menu' =>$menu]);
	// }

	public function forTemplate(){
		return $this->renderWith('Includes/MenuBlockMobile_'.$this->Type);
	}

}