<?php

class HomePage extends Page {
	private static $icon = "home";

	private static $description = "Startseite";

	public function canCreate($member = null, $context = null){
		return HomePage::get()->count() == 0;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->replaceField('Root.Main.URLSegment',$fields->FieldByName('Root.Main.URLSegment')->performReadonlyTransformation());

		return $fields;
	}
}