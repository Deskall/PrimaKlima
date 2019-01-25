<?php

class PrivatePolicyPage extends Page {
	
	private static $icon = "lock";

	private static $description = "Datenschutzerklärung";

	public function canCreate($member = null, $context = null){
		return PrivatePolicyPage::get()->count() == 0;
	}

	public function canDelete($member = null, $context = null){
		return false;
	}

}