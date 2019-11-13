<?php
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\TreeDropdownField;

class ShopPage extends Page {
	private static $singular_name = "Bestellung Seite";

	private static $has_one = [
		'RedirectPage' => SiteTree::class
	];

	public function canCreate($member = null, $context = array()){
		return ShopPage::get()->count() == 0;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('BlockTitle');
		$fields->removeByName('ElementalArea');
	 	$fields->addFieldToTab('Root.Main',TreeDropdownField::create('RedirectPageID',_t('Form.RedirectPage', 'erfolgreiche Einreichungsseite'), SiteTree::class));
	 	return $fields;
	}


}