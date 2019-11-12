<?php

use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;

class CookApplication extends DataObject{

	private static $db = array(
		'Content' => 'Text',
		'isRead'  => 'Boolean'
	);

	private static $has_one = array(
		'Cook' => Cook::class,
		'EmployerAdvertisement' => EmployerAdvertisement::class,
	);

	private static $many_many = array(
		'Attachements' => File::class,
	);
	private static $many_many_extraFields = array(
		'Attachements' => array('SortOrder' => 'Int')
	);


	private static $singular_name = 'Bewerbung';
	private static $plural_name = 'Bewerbungen';


	private static $default_sort = "Created DESC";

	private static $summary_fields = array(
		'CookName' => 'Koch',
		'EmployerName' => 'Arbeitgeber',
		'Advertisement' => 'Inserat',
		'CreatenDate' => 'Datum',
	);

	public function CookName(){
		return $this->Cook()->FirstName.' '.$this->Cook()->Surname;
	}

	public function EmployerName(){
		return $this->EmployerAdvertisement()->Employer()->Company;
	}

	public function Advertisement(){
		return $this->EmployerAdvertisement()->ContentIntro.' '.$this->EmployerAdvertisement()->ContentTitle;
	}

	public function CreatenDate(){
		return date('d.m.Y', strtotime($this->Created));
	}

	public function isEmployer(){
		return Security::getCurrentUser()->ClassName == "Employer";
	}


}