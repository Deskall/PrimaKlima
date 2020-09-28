<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\ListboxField;

class CategoryDependency extends DataObject {
	
	private static $db = [
		'Description' => 'Varchar',
		'isGlobal' => 'Boolean(1)'
	];

	private static $has_one = [
		'Parent' => ProductCategory::class
	];

	private static $many_many = [
		'RequiredCategories' => ProductCategory::class,
		'Codes' => PostalCode::class,
		'ExcludedCodes' => PostalCode::class
	];
	
	private static $summary_fields = [
		'Description'
	];
	

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Description'] = 'Kurs Beschreibung';
		$labels['Parent'] = 'Kategorie';
		$labels['Codes'] = 'betroffene Ortschaften';
		$labels['ExcludedCodes'] = 'ausgeschlossene Ortschaften';
		$labels['RequiredCategories'] = 'Abhängigkeiten';
		$labels['isGlobal'] = 'Stimmt für alle Ortschaften';
		return $labels;
	}


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('RequiredCategories');
		$fields->removeByName('ExcludedCodes');
		$fields->removeByName('Codes');
		$fields->removeByName('ParentID');
		return $fields;
	}
}