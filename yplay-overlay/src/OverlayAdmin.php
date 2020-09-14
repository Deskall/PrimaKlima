<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldImportButton;

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
		],
		'Rate' => [
			'title' => 'Bewertungen'
		]
	];

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);
	    if($this->modelClass== Rate::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))){
            $form->Fields()->fieldByName("Rate")->getConfig()->removeComponentsByType([GridFieldAddNewButton::class, GridFieldImportButton::class]);
        }
	    return $form;
	}

	public function getList(){
		$list = parent::getList();
		
		return $list;
	}

}