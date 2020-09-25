<?php

use SilverStripe\Subsites\State\SubsiteState;

class HomePage extends Page {
	private static $icon_class = "font-icon-home";

	private static $description = "Startseite";

	public function canCreate($member = null, $context = null){
		if ($this->hasExtension('SilverStripe\Subsites\Extensions\SiteTreeSubsites')){
			return HomePage::get()->filter('SubsiteID',SubsiteState::singleton()->getSubsiteId())->count() == 0;
		}
		else {
			return HomePage::get()->count() == 0;
		}
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		//$fields->FieldByName('Root.Main.URLSegment')->setReadonly(true)->addExtraClass("no-edit");
		$fields->removeByName('URLSegment');

		return $fields;
	}
}