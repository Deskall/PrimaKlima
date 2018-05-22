<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;

class LayoutLink extends DataObject{

	private static $db = [
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
		'NiceLinkType',
		'NiceTitle',
		'NiceURL'
	];

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	 	$labels['NiceLinkType'] = _t(__CLASS__.'.LinkType','Typ');
	 	$labels['NiceTitle'] = _t(__CLASS__.'.LinkTitle','Titel');
	 	$labels['NiceURL'] = _t(__CLASS__.'.LinkURL','URL');
	    $labels['DisplayLink'] = _t(__CLASS__.'.Link','Link');
	   
	 
	    return $labels;
	}

	public function NiceLinkType(){
		return $this->LinkableLink()->Type;
	}

	public function NiceLinkTitle(){
		return $this->LinkableLink()->Title;
	}

	public function NiceURL(){
		return $this->DisplayLink();
	}

	
	public function getCMSFields(){
		$fields = parent::getCMSFields();

        $fields->removeByName('ParentID');
        $fields->removeByName('Type');
      
        return $fields;
    }

   

    public function DisplayLink(){
    	$html = '<div><span>'.$this->LinkableLink()->getLinkType().'</span><span>'.$this->LinkableLink()->Title.'</span><span>'.$this->LinkableLink()->LinkURL.'</span></div>';
    	return DBField::create_field('HTMLText', $html)->Summary(20);
    }

    public function forTemplate(){
    	return $this->renderWith('Includes/'.__CLASS__);
    }
}
