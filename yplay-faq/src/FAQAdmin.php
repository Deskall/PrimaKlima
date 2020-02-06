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

class FAQAdmin extends ModelAdmin{

	private static $menu_icon_class = "font-icon-book";
	private static $url_segment = "faq";
	private static $menu_title = "FAQ";
	
	private static $managed_models = [
		'FAQCategory' => [
			'title' => 'Kategorien'
		],
		'FAQItem'  => [
			'title' => 'Items'
		]
	];

	

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);

	   

	    if($this->modelClass == 'FAQItem' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }

	    return $form;
	}

	public function getList(){
		$list = parent::getList();
		
		return $list;
	}

}