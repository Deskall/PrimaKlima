<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class ProductDependency extends DataObject {
	
	private static $db = [
		'isGlobal' => 'Boolean(1)',
		'notIndenpendent' => 'Boolean(1)'
	];

	private static $has_one = [
		'Parent' => ProductCategory::class
	];

	private static $many_many = [
		'Categories' => ProductCategory::class,
		'Codes' => PostalCode::class,
		'ExcludedCodes' => PostalCode::class
	];
	
	private static $summary_fields = [
		
	];
	

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Parent'] = 'Kategorie';
		$labels['Codes'] = 'betroffene Ortschaften';
		$labels['ExcludedCodes'] = 'ausgeschlossene Ortschaften';
		$labels['Categories'] = 'Abhängigkeiten';
		$labels['isGlobal'] = 'Stimmt für alle Ortschaften';
		$labels['notIndenpendent'] = 'Kann nicht unabhängig bestellt werden';
		return $labels;
	}


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('ParentID');
		return $fields;
	}
}