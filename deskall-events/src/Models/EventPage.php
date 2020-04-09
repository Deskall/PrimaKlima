<?php

use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class EventPage extends Page {

	public function getEventConfig(){
		return EventConfig::get()->first();
	}

	public function activeEvents(){
		return Event::get()->filter(['isVisible' => 1,'Closed' => 0]);
	}

	public function MainEventPage(){
		return $this->getEventConfig()->MainPage();
	}

	public function SubEventPage(){
		return $this->getEventConfig()->AllEventsPage();
	}
}