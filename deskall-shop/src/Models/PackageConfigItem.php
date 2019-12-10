<?php
use SilverStripe\ORM\DataObject;

class PackageConfigItem extends DataObject{
	private static $db = array(
		'Title' => 'Varchar(255)',
		'SortOrder' => 'Int',
		'Description' => 'HTMLText'
	);

	private static $summary_fields = array(
		'Title' => 'Titel',
	);


	private static $singular_name = 'Feature';
	private static $plural_name = 'Features';


}




