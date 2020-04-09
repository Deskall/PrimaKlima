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

class EventAdmin extends ModelAdmin{

	private static $menu_icon_class = "font-icon-book-open";
	private static $url_segment = "kurse";
	private static $menu_title = "Kurse";
	
	private static $managed_models = [
		'Event' => [
			'title' => 'Kurse'
		],
		'EventOrder' => [
			'title' => 'Bestellungen'
		],
		'EventCoupon' => [
			'title' => 'Gutscheine'
		],
		'EventConfig' => [
			'title' => 'Einstellungen'
		],

	];

	public function getList(){
		$list = parent::getList();
		return $list;
	}

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);

	    if($this->modelClass == 'Event' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDuplicateAction());
	    }

	    return $form;
	}

}