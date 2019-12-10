<?php
use SilverStripe\ORM\DataObject;

class PackageOption extends DataObject{
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Price' => 'Currency',
		'SortOrder' => 'Int',
		'RunTime' => 'Int',
		'RunTimeCurrency' => 'Varchar(255)',
	);

	private static $has_one = array(
		'Package' => 'Package',
	);

	private static $summary_fields = array(
		'Title' => 'Titel',
	);
}




