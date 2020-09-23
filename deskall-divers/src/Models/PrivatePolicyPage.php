<?php

class PrivatePolicyPage extends Page {

	private static $singular_name = "Datenschutzerklärung";

	private static $plural_name = "Datenschutzerklärungen";
	
	private static $icon_class = "font-icon-lock";

	private static $description = "Enthält die Datenschutzerklärung der Website";

	public function canCreate($member = null, $context = null){
		return PrivatePolicyPage::get()->count() == 0;
	}

	public function canDelete($member = null, $context = null){
		return false;
	}

}