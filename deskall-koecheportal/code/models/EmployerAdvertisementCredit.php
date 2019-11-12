<?php
use SilverStripe\ORM\DataObject;

class EmployerAdvertisementCredit extends DataObject{

	private static $db = array(
		'RunTime' => 'Int',
		'RunTimeCurrency' => 'Varchar(255)',
		'RunTimeTitle' => 'Varchar(255)',
	);


	private static $has_one = array(
		'Employer' => 'Employer',
		'Package' => 'Package'
	);


	private static $summary_fields = array(
		'RunTimeTitle' => 'Anzeigenschaltung für xxx Wochen',
		'Package.Title__de_DE' => 'Paket'
	);



}