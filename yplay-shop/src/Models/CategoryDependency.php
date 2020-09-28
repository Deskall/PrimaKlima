<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\Tab;

class CategoryDependency extends DataObject {

	private static $singular_name = "Spezifisch Behandlung";
	private static $plural_name = "Spezifische Behandlungen";
	
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
		'Description',
		'Concerned' => 'betroffene Ortschaften',
		'Excluded' => 'ausgeschlossene Ortschaften'
	];
	

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Description'] = 'Kurs Beschreibung';
		$labels['Parent'] = 'Kategorie';
		$labels['Action'] = 'Behandlung';
		$labels['Codes'] = 'betroffene Ortschaften';
		$labels['ExcludedCodes'] = 'ausgeschlossene Ortschaften';
		$labels['RequiredCategories'] = 'Abhängigkeiten';
		return $labels;
	}


	public function getCMSFields(){
		$fields = FieldList::create();
		$fields->push(new Tabset('Root', new Tab('Main','Detail')));
		$fields->addFieldToTab('Root.Main', TextField::create('Description',$this->fieldLabels()['Description']));
		$fields->insertAfter('Description',DropdownField::create('Action',$this->fieldLabels()['Description'], ['unavailable' => 'ist nicht verfügbar', 'inactive' => 'ist standardmäßig inaktiv', 'depends' => 'kann nur mit anderen Kategorien bestellt sein'])->setEmptyString('Bitte Behandlung wählen'));
		$fields->insertAfter('Action', ListboxField::create('RequiredCategories',$this->fieldLabels()['RequiredCategories'], ProductCategory::get()->exclude('ID',$this->ParentID)->map('ID','Title'), $this->RequiredCategories())->setAttribute('data-placeholder','Bitte Kategorie(n) eingeben')->displayIf('Action')->isEqualTo('depends')->end());

		$fields->addFieldToTab('Root.Main', ListboxField::create('Codes',$this->fieldLabels()['Codes'], PostalCode::get()->map('ID','Code'), $this->Codes())->setAttribute('data-placeholder','Alle Ortschaften sind betroffen'));
		$fields->insertAfter('Codes', ListboxField::create('ExcludedCodes',$this->fieldLabels()['ExcludedCodes'], PostalCode::get()->map('ID','Code'), $this->ExcludedCodes())->setAttribute('data-placeholder','Keine Ortschaften sind ausgeschlossen'));
		return $fields;
	}

	public function Concerned(){
		return ( $this->Codes()->exists() ) ? $this->Codes()->columns('Code') : "Alle";
	}

	public function Excluded(){
		return ( $this->ExcludedCodes()->exists() ) ? $this->ExcludedCodes()->columns('Code') : "Keine";
	}
}