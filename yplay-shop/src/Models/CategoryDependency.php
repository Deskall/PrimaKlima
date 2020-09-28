<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\Tab;

class CategoryDependency extends DataObject {
	
	private static $db = [
		'Description' => 'Varchar',
		'Action' => 'Varchar'
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
		$labels['Action'] = 'Einstellung';
		$labels['Codes'] = 'betroffene Ortschaften';
		$labels['ExcludedCodes'] = 'ausgeschlossene Ortschaften';
		$labels['RequiredCategories'] = 'Abhängigkeiten';
		return $labels;
	}


	public function getCMSFields(){
		$fields = FieldList::create();
		$fields->push(new Tabset('Root', new Tab('Main','Detail')));
		
		$fields->addFieldToTab('Root.Main', TextField::create('Description',$this->fieldLabels()['Description']));
		$fields->insertAfter('Description', ListboxField::create('Codes',$this->fieldLabels()['Codes'], PostalCode::get()->map('ID','Code'), $this->Codes())->setAttribute('data-placeholder','Alle Ortschaften sind betroffen'));
		$fields->insertAfter('Codes', ListboxField::create('ExcludedCodes',$this->fieldLabels()['ExcludedCodes'], PostalCode::get()->map('ID','Code'), $this->ExcludedCodes())->setAttribute('data-placeholder','Keine Ortschaften sind ausgeschlossen'));
		return $fields;
	}
}