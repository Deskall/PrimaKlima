<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\DropdownField;

class ShopAction extends DataObject {

	private static $singular_name = 'Aktion';

	private static $plural_name = 'Aktionen';

	private static $db = [
		'Title' => 'Varchar',
		'Lead' => 'Text',
		'Description' => 'HTMLText',
		'Start' => 'Date',
		'End' => 'Date',
		'Trigger' => 'Varchar',
		'Conditions' => 'HTMLText',
		'Cumulative' => 'Boolean(0)'
	];

	private static $has_one = [
		'Image' => Image::class,
		'Icon' => Image::class
	];

	private static $has_many = [
		'Variations' => PriceVariation::class
	];

	private static $cascade_deletes = [
		'Variations'
	];

	private static $extensions = [
		'Sortable',
		'Activable'
	];

	private static $summary_fields = [
		'Title',
		'Products' => ['title' => 'Produkte / Pakete'],
		'Codes' => ['title' => 'Ortschaften'],
		'isCumulative' => ['title' => 'Kann diese Aktion mit anderen kombiniert werden?']
	];

	private static $searchable_fields = [
		'Title'
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = _t(__CLASS__.'.Title','Titel');
		$labels['Lead'] = _t(__CLASS__.'.Lead','Lead');
		$labels['Description'] = _t(__CLASS__.'.Description','Beschreibung');
		$labels['Start'] = _t(__CLASS__.'.Start','Anfang');
		$labels['End'] = _t(__CLASS__.'.End','Ende');
		$labels['Trigger'] = _t(__CLASS__.'.Trigger','Auslösung');
		$labels['isGlobal'] = _t(__CLASS__.'.isGlobal','Global?');
		$labels['Conditions'] = _t(__CLASS__.'.Conditions','Konditionen');
		$labels['Image'] = _t(__CLASS__.'.Image','Bild');
		$labels['Icon'] = _t(__CLASS__.'.Icon','Icon');
		$labels['Variations'] = _t(__CLASS__.'.Variations','Discounts');
		$labels['Cumulative'] = _t(__CLASS__.'.Cumulative','Kann diese Aktion mit anderen kombiniert werden?');
	
		return $labels;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->insertAfter('Title',DropdownField::create('Trigger',$this->fieldLabels()['Trigger'],['always' => 'immer', 'new' => 'neu Kunde']));

		return $fields;
	}

	public function Products(){
		$html = '<p>';
		foreach ($this->Variations() as $v) {
			foreach ($v->Products() as $p) {
				$html .=  $p->Title.'<br>';
			}
		}
		$html .= '</p>';
		return DBHTMLText::create()->setValue($html);
	}

	public function Codes(){
		$html = '<p>';
		foreach ($this->Variations() as $v) {
			foreach ($v->Codes() as $c) {
				$html .=  $c->Code.'<br>';
			}
		}
		$html .= '</p>';
		return DBHTMLText::create()->setValue($html);
	}

	public function isCumulative(){
		return ($this->Cumulative) ? 'Ja' : 'Nein';
	}
}