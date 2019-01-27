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
        'URL' => 'Varchar',
        'ThumbnailURL' => 'Varchar'
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
		$fields->addFieldToTab('Root.Main',HTMLEditorField::create('HTML',_t(__CLASS__.'HTML','Beschreibung'))->setRows(3));

		return $fields;
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if ($this->Player){
			switch ($this->Player){
				case "youtube":
				 $this->URL = "https://www.youtube-nocookie.com/watch?v=".$this->VideoID;
				 $this->ThumbnailURL = "http://i3.ytimg.com/vi/".$this->VideoID."/hqdefault.jpg";
				break;
				case "vimeo":
					$this->URL = "https://vimeo.com/".$this->VideoID;
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/".$this->VideoID.".php"));
					$this->ThumbnailURL = $hash[0]['thumbnail_large'];
				break;
				case "dailymotion":
				    $this->URL = "https://www.dailymotion.com/video/".$this->VideoID;
				    $hash = json_decode(file_get_contents('https://api.dailymotion.com/video/'.$this->VideoID.'?fields=thumbnail_large_url'));
				    ob_start();
				    			print_r($hash);
				    			$result = ob_get_clean();
				    			file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
				    // $this->ThumbnailURL = $hash[0];
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