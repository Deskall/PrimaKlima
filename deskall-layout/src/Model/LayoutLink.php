<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;

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
		'LinkableLink.LinkType' => 'Typ',
		'LinkableLink.Title' => 'Titel',
		'LinkableLink.LinkURL' => 'URL',
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
        $fields->addFieldToTab('Root.Main',HTMLDropdownField::create('Icon',_t(__CLASS__. '.Icon','Icon'),$this->getSourceIcons())->setEmptyString(_t(__CLASS__. '.IconLabel','Icon hinzufügen'))->addExtraClass('columns'));
        return $fields;
    }

    public function getSourceIcons(){
        //To do : filter relevant icons
        return HTMLDropdownField::getSourceIcones();
    }

    public function DisplayLink(){
    	$html = '<div><span>'.$this->LinkableLink()->getLinkType().'</span><span>'.$this->LinkableLink()->Title.'</span><span>'.$this->LinkableLink()->LinkURL.'</span></div>';
    	return DBField::create_field('HTMLText', $html)->Summary(20);
    }

    public function forTemplate(){
    	return $this->renderWith('Includes/'.__CLASS__);
    }
}
