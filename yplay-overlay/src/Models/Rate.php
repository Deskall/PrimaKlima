<?php

use SilverStripe\ORM\DataObject;


class Rate extends DataObject{

	private static $singular_name = 'Bewertung';
	private static $plural_name = 'Bewertungen';

	private static $db = [
		'Datum' => 'Date',
		'Bewertung' => 'Varchar',
		'Bemerkungen' => 'Text',
		'PLZ' => 'Varchar(255)'
	];

	private static $has_one = ['Overlay' => Overlay::class];

	private static $summary_fields = [
		'Datum',
		'Bewertung',
		'PLZ',
		'Bemerkungen'
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		return $fields;
	}

	public function canEdit($member = null){
		return false;
	}

}