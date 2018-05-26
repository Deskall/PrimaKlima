<?php
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField_Readonly;

class HomePage extends Page {
	private static $icon = "home";

	private static $description = "Startseite";

	public function canCreate($member = null, $context = null){
		return HomePage::get()->count() == 0;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->replaceField('Root.Main.URLSegment',SiteTreeURLSegmentField_Readonly::create('URLSegment',_t('SiteTree.URLSegment','URL-Segment'))->performReadonlyTransformation());

		return $fields;
	}
}