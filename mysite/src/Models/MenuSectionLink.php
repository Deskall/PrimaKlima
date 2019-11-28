<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;

class MenuSectionLink extends DataObject{

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

	private static $db = [
		'Type' => 'Varchar(255)',
		'Label' => 'Varchar',
		'Background' => 'Varchar'
	];

	private static $has_one = ['MenuParent' => MenuSection::class ];	

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	 	$labels['NiceLinkType'] = _t(__CLASS__.'.LinkType','Typ');
	 	$labels['NiceTitle'] = _t(__CLASS__.'.LinkTitle','Titel');
	 	$labels['NiceURL'] = _t(__CLASS__.'.LinkURL','URL');
	   // $labels['DisplayLink'] = _t(__CLASS__.'.Link','Link');
	   
	 
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Background');
		$fields->removeByName('Type');
		$fields->push(HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Label Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'));
		
		// $fields->FieldByName('Background')->displayIf('Label')->isNotNull()->end();
		return $fields;
	}


	public function NiceLinkType(){
		return $this->LinkableLink()->getLinkType();
	}

	public function NiceTitle(){
		return $this->LinkableLink()->Title;
	}

	public function NiceURL(){
		return $this->LinkableLink()->LinkURL;
	}


   

    public function DisplayLink(){
    	$html = '<div><span>'.$this->LinkableLink()->getLinkType().'</span><span>'.$this->LinkableLink()->Title.'</span><span>'.$this->LinkableLink()->LinkURL.'</span></div>';
    	return DBField::create_field('HTMLText', $html)->Summary(20);
    }

    
}
