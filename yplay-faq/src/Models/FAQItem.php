<?php

use SilverStripe\ORM\DataObject;


class FAQItem extends DataObject{

	private static $singular_name = 'FAQ Item';
	private static $plural_name = 'FAQ Items';

	private static $db = [
		'Title' => 'Varchar(255)',
		'Summary' => 'HTMLText', 
		'Text' => 'HTMLText',
		'DisplayInSearchModal' => 'Boolean(0)'
	];

	private static $belongs_many_many = [
		'Categories' => FAQCategory::class
	];

	private static $many_many = [
		'RelatedItems' => FAQItem::class
	];

	private static $extensions = [
		'Activable',
		'Sortable'
	];


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Summary'] = 'Einstiegstext';
	    $labels['Text'] = 'Text';
	    $labels['Categories'] = 'Kategorien';
	    $labels['RelatedItems'] = 'verbundene Items';
	 
	    return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		// $fields->fieldByName('Root.Main.CategoryID')->setEmptyString('Bitte Kategorie auswählen');

		return $fields;
	}

	public function removefromsearch(){
		$this->DisplayInSearchModal = 0;
		$this->write();
	}

	public function showinsearch(){
		$this->DisplayInSearchModal = 1;
		$this->show();
	}

	
}