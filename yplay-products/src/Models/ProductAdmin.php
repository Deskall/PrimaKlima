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

class ProductAdmin extends ModelAdmin{

	private static $menu_icon_class = "font-icon-database";
	private static $url_segment = "shop";
	private static $menu_title = "Shop";
	
	private static $managed_models = [
		'ProductCategory' => [
			'title' => 'Kategorien'
		],
		'PostalCode' => [
			'title' => 'Ortschaften'
		],
	];

	

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);

	   

	    if($this->modelClass == 'ProductCategory' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }

	    return $form;
	}

	public function getList(){
		$list = parent::getList();
		 
		return $list;
	}

}