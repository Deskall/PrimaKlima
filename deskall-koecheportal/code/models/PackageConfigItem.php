<?php
use SilverStripe\ORM\DataObject;

class PackageConfigItem extends DataObject{
	private static $db = array(
		'Title__de_DE' => 'Varchar(255)',
		'SortOrder' => 'Int',
		'Description__de_DE' => 'HTMLText'
	);

	private static $summary_fields = array(
		'Title__de_DE' => 'Titel',
	);


	static $singular_name = 'Feature';
	static $plural_name = 'Features';


}




