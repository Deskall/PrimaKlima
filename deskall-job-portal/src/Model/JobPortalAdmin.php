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

class JobPortalAdmin extends ModelAdmin{
	
	private static $url_segment = 'jobportal';
	private static $menu_title = 'Gastroportal';
	private static $menu_icon = 'deskall-job-portal/img/icon-employer.png';
	private static $menu_priority = 2;
	
	private static $managed_models = [
		'Mission' => [
			'title' => 'Stellen'
		],
		'JobGiver' => [
			'title' => 'Arbeitgeber'
		],
		'Candidat' => [
			'title' => 'Kandidaten'
		],
		'MatchingQuery' => [
			'title' => 'Matching Tool Anfragen'
		],
		'JobPortalConfig' => [
			'title' => 'Einstellungen'
		]
	];

	public function getList(){
		$list = parent::getList();

		return $list;
	}

	public function getEditForm($id = null, $fields = null) {
	    $form = parent::getEditForm($id, $fields);
	     if($this->modelClass == 'Mission' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) {
	       $gridField->getConfig()->addComponent(new GridFieldDuplicateAction());
	    }
	    return $form;
	}

}