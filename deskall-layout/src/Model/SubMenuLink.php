<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class SubMenuLink extends LayoutLink{

	private static $db = [
		'Text' => 'HTMLText'
	];

	private static $has_one = [
		'Image' => Image::class
	];

	private static $extensions = [
		
	];

	private static $summary_fields = [
		
	];

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	 
	    return $labels;
	}
	
	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Main',UploadField::create('Image','Bild')->setFolderName($this->generateFolderName()));
		$fields->addFieldToTab('Root.Main',HTMLEditorField::create('Text','Einstigstext')->setRows(3));
      
        return $fields;
    }

    public function forTemplate(){
    	return $this->renderWith('Includes/'.__CLASS__);
    }
}
