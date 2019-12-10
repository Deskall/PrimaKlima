<?php
use SilverStripe\ORM\DataObject;

class PackageConfigItem extends DataObject{
	private static $db = array(
		'Title__de_DE' => 'Varchar(255)',
		'Description__de_DE' => 'HTMLText'
	);

	private static $summary_fields = array(
		'Title__de_DE' => 'Titel',
	);

	private static $extensions = [
		'Activable',
		'Sortable'
	];


	private static $singular_name = 'Feature';
	private static $plural_name = 'Features';

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title__de_DE'] = 'Titel';
		$labels['Description__de_DE'] = 'Beschreibung';
		return $labels;
	}


}




