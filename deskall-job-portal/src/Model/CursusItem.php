<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;

class CursusItem extends DataObject {

	private static $db = array(
		'StartDate' => 'Date',
		'EndDate' => 'Date',
		'School' => 'Varchar',
		'Diplom' => 'Varchar'	
	);

	private static $has_one = array(
		'Candidat' => Candidat::class
	);

	private static $extensions = ['Sortable'];

	private static $summary_fields = array(
		'StartDate' => 'Von',
		'EndDate' => 'Bis',
		'School' => 'Schule',
		'Diplom' => 'Ausbildung'
	);

	private static $singular_name = 'Ausbildung';
	private static $plural_name = 'Ausbildungen';

	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('CandidatID');
		$fields->addFieldToTab('Root.Main', DateField::create('StartDate', _t('KOCH.StartDate', 'Von'))->setConfig('dateformat', 'YYYY/MM')->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.Main', DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('dateformat', 'YYYY/MM')->setConfig('showcalendar', true) );
		$fields->addFieldToTab('Root.Main', TextField::create('School', _t('KOCH.School', 'Schule')) );
		$fields->addFieldToTab('Root.Main', TextField::create('Diplom', _t('KOCH.Diplom', 'Ausbildung')) );
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

	public function canCreate( $member = NULL, $context = [] ){
		return true;
	}

	public function canPublish( $member = NULL ){
		return true;
	}

	public function canUnpublish( $member = NULL ){
		return true;
	}




}
