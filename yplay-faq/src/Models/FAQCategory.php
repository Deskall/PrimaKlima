<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;

class FAQCategory extends DataObject{

	private static $singular_name = 'FAQ Kategorie';
	private static $plural_name = 'FAQ Kategorien';

	private static $db = [
		'Title' => 'Varchar(255)',
		'Summary' => 'HTMLText'
	];

	private static $has_one = ['Icon' => Image::class];

	private $owns = ['Icon'];

	private static $many_many = [
		'Items' => FAQItem::class
	];

	private static $extensions = [
		'Activable',
		'Sortable'
	];


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Summary'] = 'Einstiegstext';
	    $labels['Icon'] = 'Icon';
	    $labels['Items'] = 'verbundene Items';
	    return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->fieldByName('Root.Main.Icon')->setFolderName($this->getFolderName());
		if ($this->ID > 0){
			$fields->dataFieldByName('Items')->getConfig()->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDisplayInSearchModalAction());
		}
		

		return $fields;
	}

	public function getFolderName(){
	    return "Uploads/FAQ";
	}


	
}