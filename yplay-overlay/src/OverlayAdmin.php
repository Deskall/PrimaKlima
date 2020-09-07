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

class OverlayAdmin extends ModelAdmin{

	private static $menu_icon_class = "font-icon-page-multiple";
	private static $url_segment = "overlay";
	private static $menu_title = "Overlay";
	
	private static $managed_models = [
		'Overlay' => [
			'title' => 'Overlays'
		],
		'OverlayForm' => [
			'title' => 'Formulare (Zb. Umfrage)'
		]
	];

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);

	    return $form;
	}

	public function getList(){
		$list = parent::getList();
		
		return $list;
	}

}