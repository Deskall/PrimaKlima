<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;

class CookCVItem extends DataObject {

	private static $db = array(
		'SortOrder' => 'Int',
		'StartDate' => 'Date',
		'EndDate' => 'Date',
		'Description' => 'Text'		
	);

	private static $has_one = array(
		'Cook' => Cook::class
	);

	private static $summary_fields = array(
		'StartDate' => 'Von',
		'EndDate' => 'Bis',
		'Description' => 'Job',
	);

	private static $singular_name = 'Job';
	private static $plural_name = 'Jobs';

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('SortOrder');
		$fields->removeByName('CookID');
		$fields->addFieldToTab('Root.Main', DateField::create('StartDate', _t('KOCH.StartDate', 'Von'))->setConfig('dateformat', 'YYYY/MM')->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.Main', DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('dateformat', 'YYYY/MM')->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.Main', TextareaField::create('Description', _t('KOCH.Description', 'Job-Beschreibung')) );
		return $fields;
	}


	public function canView( $member = NULL ){
		return true;
	}

	public function canEdit( $member = NULL ){
		return true;
	}


	public function canDelete( $member = NULL ){
		return true;
	}

	public function canCreate( $member = NULL , $context = Array){
		return true;
	}

	public function canPublish( $member = NULL ){
		return true;
	}

	public function canUnpublish( $member = NULL ){
		return true;
	}




}
