<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;

class CVItem extends DataObject {

	private static $db = array(
		'StartDate' => 'Date',
		'EndDate' => 'Date',
		'Description' => 'Text'		
	);

	private static $has_one = array(
		'Candidat' => Candidat::class
	);

	private static $extensions = [
		'Sortable',
		'SubObjectPermission'
	];

	private static $summary_fields = array(
		'StartDate' => 'Von',
		'EndDate' => 'Bis',
		'Description' => 'Job',
	);

	static $singular_name = 'Job';
	static $plural_name = 'Jobs';

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('CandidatID');
		$fields->addFieldToTab('Root.Main', DateField::create('StartDate', _t('KOCH.StartDate', 'Von'))->setConfig('dateformat', 'YYYY/MM')->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.Main', DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('dateformat', 'YYYY/MM')->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.Main', TextareaField::create('Description', _t('KOCH.Description', 'Job-Beschreibung')) );
		return $fields;
	}
}
