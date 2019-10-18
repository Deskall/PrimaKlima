<?php
use SilverStripe\SiteConfig\SiteConfig;

class LateralSection extends MenuSection{

	private static $singular_name = 'Sidebar Menu';
	private static $plural_name = 'Sidebar Menus';

	private static $db = [
		'ButtonTitle' => 'Varchar(255)',
		'ButtonFarbe' => 'Varchar(255)',
		'ButtonIcon' => 'Varchar(255)'
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Image');
		$fields->insertAfter('ButtonTitle',HTMLDropdownField::create('ButtonFarbe',_t('Form.ButtonBackground','Button Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'));
		$fields->insertAfter('ButtonFarbe',HTMLDropdownField::create('ButtonIcon', _t(__CLASS__.'.Icone','button Icon'), HTMLDropdownField::getSourceIcones(), 'check')->addExtraClass('columns'));
		return $fields;
	}

}