<?php
use SilverStripe\ORM\DataObject;

class CookConfigItem extends DataObject{
	private static $db = array(
		'Title__de_DE' => 'Varchar(255)'
	);
}

class CookLanguageConfigItem extends CookConfigItem{
	private static $db = array(
		'Code' => 'Varchar(255)'
	);
}



