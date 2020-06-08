<?php
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;

class OfferPage extends Page {
	private static $has_one = [
		'RedirectWithOffer' => SiteTree::class,
		'RedirectWithoutOffer' => SiteTree::class
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->insertBefore('BlockTitle',TreeDropdownField::create('RedirectWithoutOfferID',_t(__CLASS__.'.RedirectPageWithout','Ohne Angebot'), SiteTree::class)->setDescription(_t(__CLASS__.'.RedirectPageWithoutDescription',  'erfolgreiche Einreichungsseite (Ohne automatisch Angebot)')));
		$fields->insertBefore('BlockTitle',TreeDropdownField::create('RedirectWithOfferID',_t(__CLASS__.'.RedirectPage','mit Angebot'), SiteTree::class)->setDescription(_t(__CLASS__.'.RedirectPageDescription', 'erfolgreiche Einreichungsseite (mit automatisch Angebot)')));
		return $fields;
	}

	//Fallback for old codes
	public function getCookConfig(){
		return $this->getPortalConfig();
	}

	public function getPortalConfig(){
		return JobPortalConfig::get()->first();
	}

	
}