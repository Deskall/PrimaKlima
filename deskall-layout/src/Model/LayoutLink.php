<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;


class LayoutLink extends DataObject{

	private static $db = [
		'Icon' => 'Varchar(255)',
		'Type' => 'Varchar(255)'
	];

	private static $has_one = [
		'Parent' => 'LayoutBlock'
	];

	private static $extensions = [
		'Activable',
        'Linkable',
        'Sortable'
	];

	private static $summary_fields = [
		'DisplayLink'
	];

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	 
	    $labels['DisplayLink'] = _t(__CLASS__.'.Link','Link');
	   
	 
	    return $labels;
	}

	
	public function getCMSFields(){
		$fields = parent::getCMSFields();

        $fields->removeByName('ParentID');
        $fields->removeByName('Type');
        $fields->addFieldToTab('Root.Main',HTMLDropdownField::create('Icon',_t(__CLASS__. '.Icon','Icon'),$this->getSourceIcons())->setEmptyString(_t(__CLASS__. '.IconLabel','Icon hinzufügen')));
        return $fields;
    }

    public function getSourceIcons(){
        //To do : filter relevant icons
        return HTMLDropdownField::getSourceIcones();
    }
}
