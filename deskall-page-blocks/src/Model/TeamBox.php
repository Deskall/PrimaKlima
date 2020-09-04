<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;

class TeamBox extends DataObject {

	private static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'Function' => 'Text',
		'Email' => 'Varchar(255)',
		'Telephone' => 'Varchar(255)'
	);

	private static $has_one = array(
		'TeamBlock' => TeamBlock::class,
		'Image' => Image::class
	);

	private static $extensions = [
		Versioned::class,
		'Activable',
		'Sortable'
	];

	
	private static $summary_fields = [
		'Thumbnail' => 'Bild',
		'Title' => 'Name',
		'Function' => 'Funktion',
		'Content' => 'Inhalt'
	];

	public function getCMSFields() {
		$fields = parent::getCMSFields();


		$fields->removeByName("TeamBlockID");
		$fields->removeByName("RelatedPageID");
		$fields->removeByName("Content");

		$fields->addFieldToTab('Root.Main', new TextareaField('Title','Name'));
		$fields->addFieldToTab('Root.Main', new TextareaField('Function','Funktion'));
		$fields->addFieldToTab('Root.Main', EmailField::create('Email','Email'));
		$fields->addFieldToTab('Root.Main', TextField::create('Telephone','Telephone'));

		$uploadField = new UploadField('Image', 'Porträt');
		$uploadField->setFolderName($this->TeamBlock()->getFolderName());
		$fields->addFieldToTab('Root.Main', $uploadField);

		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content','Inhalt')->setRows(10));

		return $fields;
	}

	public function Thumbnail(){
	    $o = new DBHTMLText();
	    $html = ($this->Image() && $this->Image()->exists()) ? (($this->Image()->getExtension() == "svg" ) ? '<img src="'.$this->Image()->URL.'" width="250" height="200" />' : '<img src="'.$this->Image()->Fill(250,200)->URL.'" />') : _t(__CLASS__.'.NoBild','(keine)');
	    $o->setValue($html);
	    return $o;
	}
}