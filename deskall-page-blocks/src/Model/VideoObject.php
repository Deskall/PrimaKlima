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
		'Type' => 'Enum("Datei,Link","Link")',
		'Player' => 'Varchar',
        'VideoID' => 'Varchar(255)',
		'Title' => 'Text',
		'HTML' => 'HTMLText',
        'URL' => 'Varchar'
	];

	private static $has_one = [
		'Parent' => VideoBlock::class,
		'File' => File::class
	];

	private static $extensions = ['Activable','Sortable'];

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
		$fields->removeByName('ParentID');
		$fields->fieldByName('Root.Main.File')->displayIf('Type')->isEqualTo('Datei');
		$fields->fieldByName('Root.Main.VideoID')->displayIf('Type')->isEqualTo('Link');
		$fields->addFieldToTab('Root.Main',DropdownField::create('Player',_t(__CLASS__.'Player','Player'),['youtube'=>'You Tube','vimeo' => 'Vimeo', 'dailymotion' => 'Dailymotion'])->setEmptyString('Player wählen')->displayIf('Type')->isEqualTo('Link')->end(),'VideoID');
		$fields->addFieldToTab('Root.Main',HTMLEditorField::create('HTML',_t(__CLASS__.'HTML','Beschreibung'))->setRows(3)->displayIf('Type')->isEqualTo('Link')->end());

		return $fields;
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if ($this->Player){
			switch ($this->Player){
				case "youtube":
				 $this->URL = "https://www.youtube-nocookie.com/embed/".$this->VideoID."?autoplay=0&amp;showinfo=0&amp;rel=0";
				break;
				case "vimeo":
					$this->URL = "https://player.vimeo.com/video/".$this->VideoID;
				break;
				case "dailymotion":
				    $this->URL = "https://www.dailymotion.com/embed/video/".$this->VideoID."?queue-autoplay-next=false&queue-autoplay-next=false";
				break;
			}
		}
	}

	public function getSrc(){
		if ($this->File()->exists()){
			return $this->File()->getURL();
		}
		return $this->URL;
	}
	
}