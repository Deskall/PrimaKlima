<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

class MenuSectionLink extends MenuLink{
	private static $db = [
		'Label' => 'Varchar',
		'Background' => 'Varchar'
	];

	private static $has_one = ['Parent' => MenuSection::class, 'Image' => Image::class];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Background');
		$fields->push(HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Label Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'));
		$fields->push(UploadField::create('Image',_t(__CLASS__.'.Image','Bild / Icon'))->setFolderName($this->Parent()->Page()->generateFolderName()));
		// $fields->FieldByName('Background')->displayIf('Label')->isNotNull()->end();
		return $fields;
	}
}