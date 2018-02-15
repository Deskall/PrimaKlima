<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;


class FooterLink extends DataObject{

	private static $db = [
		'SortOrder' => 'Int',
		'Content' => 'HTMLText',
		'Icon' => 'Varchar(255)'
	];

	private static $has_one = [
		'Parent' => 'FooterBlock'
	];

	private static $extensions = [
		'Activable',
        'Linkable'
	];

	private static $summary_fields = [
		'DisplayLink' => 'Link'
	];

	private static $icons = [
		'chevron-right' => 'chevron-right',
		'home' => 'home',
		'mail' => 'Email',
		'receiver' => 'Telefon',
		'location' => 'Marker',
		'facebook' => 'facebook',
		'twitter' => 'twitter',
		'google-plus' => 'google-plus',
		'linkedin' => 'linkedin',
		'xing' => 'xing'
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();

        $fields->removeByName('SortOrder');
        $fields->removeByName('ParentID');
        $fields->addFieldToTab('Root.Main',DropdownField::create('Icon','Icon',self::$icons)->setEmptyString('Icon hinzufügen'));
        return $fields;
    }
}
