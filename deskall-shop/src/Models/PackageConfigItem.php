<?php
use SilverStripe\ORM\DataObject;

class PackageConfigItem extends DataObject{
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Description' => 'HTMLText'
	);

	private static $summary_fields = array(
		'Title' => 'Titel',
	);

	private static $extensions = [
		'Activable',
		'Sortable'
	];


	private static $singular_name = 'Feature';
	private static $plural_name = 'Features';

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = 'Titel';
		$labels['Description'] = 'Beschreibung';
		return $labels;
	}


}




