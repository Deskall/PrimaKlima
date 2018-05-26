<?php

class HomePage extends Page {
	private static $icon = "home";

	private static $description = "Startseite";

	public function canCreate($member = null, $context = null){
		return HomePage::get()->count() == 0;
	}
}