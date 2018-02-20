<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;


class FooterLink extends DataObject{

	private static $db = [
		'SortOrder' => 'Int',
		'Content' => 'HTMLText',
		'Icon' => 'Varchar(255)',
		'Type' => 'Varchar(255)'
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


	private static $block_types = [
		'adresse' => 'Adresse',
		'links' => 'Links', 
		'text' => 'Text'
	];

	private static $icons = [
		'chevron-right' => 'chevron-right',
		'home' => 'home',
		'mail' => 'Email',
		'receiver' => 'Telefon',
		'location' => 'Marker',
		'user' => 'Person',
		'users' => 'Personen',
		'tag' => 'Tag',
		'calendar' => 'Kalender',
		'search' => 'Suche'
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
        $fields->removeByName('Type');
        //$fields->addFieldToTab('Root.Main',DropdownField::create('Type', 'LinkTyp',self::$block_types)->setEmptyString('Bitte Typ auswählen'),'Content');
        $fields->FieldByName('Root.Main.Content')->setRows(3);
        $fields->addFieldToTab('Root.Main',DropdownField::create('Icon','Icon',self::$icons)->setEmptyString('Icon hinzufügen'), 'Content');
        $fields->insertAfter($fields->FieldByName('Root.Main.Content'),'CallToActionLink');
        return $fields;
    }
}
