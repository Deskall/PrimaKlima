<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\DB;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class RestaurantMenuAdmin extends ModelAdmin{

	private static $menu_icon_class = "font-icon-book-open";
	private static $url_segment = "menu";
	private static $menu_title = "Menü";
	
	private static $managed_models = [
		'MenuCarte' => [
			'title' => 'Karte'
		],
		'Menu' => [
			'title' => 'Menü'
		],
		'Dish' => [
			'title' => 'Speisen'
		],
		'DishCategory' => [
			'title' => 'Speise Sorten'
		],
		'MenuConfig' => [
			'title' => 'Einstellungen'
		]
	];

	public function getList(){
		$list = parent::getList();
		return $list;
	}

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);

	    if($this->modelClass == 'Menu' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }
	    if($this->modelClass == 'Dish' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }
	    if($this->modelClass == 'DishCategory' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction()));
	    }

	    return $form;
	}

}