<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class VideoObject extends DataObject{

    private static $table_name = 'VideoObject';

    private static $singular_name = 'Video';

    private static $plural_name = 'Video';

    private static $description = 'Video';

	private static $db = [
		'HTML' => 'HTMLText',
        'Title' => 'Text',
        'Player' => 'Varchar',
        'VideoID' => 'Varchar(255)',
        'URL' => 'Varchar',
	];

	private static $has_one = [
		'Parent' => VideoBlock::class,
		'File' => File::class
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);

		$labels['Title'] = _t(__CLASS__.".Title",'Titel');
		$labels['HTML'] = _t(__CLASS__.".HTML",'Inhalt');
		$labels['VideoID'] = _t(__CLASS__.".VideoID",'ID der Video');
		$labels['File'] = _t(__CLASS__.".File",'Datei');

		return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('URL');
		$fields->addFieldToTab('Root.Main',DropdownField::create('Player',_t(__CLASS__.'Player','Player'),['youtube'=>'You Tube','vimeo' => 'Vimeo', 'dailymotion' => 'Dailymotion'])->setEmptyString('Player wählen'),'Title');
		$fields->addFieldToTab('Root.Main',HTMLEditorField::create('HTML',_t(__CLASS__.'HTML','Beschreibung'))->setRows(3),'Player');

		return $fields;
	}

	public function getSrc(){
		if ($this->File()->exists()){
			return $this->File()->getURL();
		}
		return $this->URL;
	}
	
}