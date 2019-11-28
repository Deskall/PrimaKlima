<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\SiteConfig\SiteConfig;


class MenuSectionLink extends LayoutLink{
	private static $db = [
		'Label' => 'Varchar',
		'Background' => 'Varchar'
	];

	private static $has_one = ['MenuParent' => MenuSection::class ];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Background');
		$fields->push(HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Label Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'));
		
		// $fields->FieldByName('Background')->displayIf('Label')->isNotNull()->end();
		return $fields;
	}
}