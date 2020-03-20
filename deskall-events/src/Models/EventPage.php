<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class EventPage extends Page {

	public function getEventConfig(){
		return EventConfig::get()->first();
	}

	public function activeEvents(){
		return Event::get()->filter('isVisible',1);
	}

	public function MainEventPage(){
		return EventPage::get()->filter('URLSegment','seminare')->first();
	}

	public function SubEventPage(){
		return EventPage::get()->filter('URLSegment','seminare-termine')->first();
	}
}