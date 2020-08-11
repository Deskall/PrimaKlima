<?php

class HomePage extends Page {
	// private static $icon = "font-icon-home";

	private static $icon_class = "font-icon-home";
	
	private static $description = "Startseite";

	public function canCreate($member = null, $context = null){
		return HomePage::get()->count() == 0;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		//$fields->FieldByName('Root.Main.URLSegment')->setReadonly(true)->addExtraClass("no-edit");
		$fields->removeByName('URLSegment');

		return $fields;
	}
}