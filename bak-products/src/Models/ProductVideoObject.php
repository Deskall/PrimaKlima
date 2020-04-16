<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use Bak\Products\Models\Product;

class ProductVideoObject extends DataObject{

    private static $table_name = 'BAK_ProductVideoObject';

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
		'Parent' => Product::class,
		'File' => File::class
	];

	private static $owns = ['File'];

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
		$fields->removeByName('ThumbnailURL');
		$fields->fieldByName('Root.Main.File')->setFolderName("Uploads/product-detail/".$this->Parent()->URLSegment)->setAllowedFileCategories('video')->displayIf('Type')->isEqualTo('Datei');

		$fields->fieldByName('Root.Main.VideoID')->displayIf('Type')->isEqualTo('Link');
		$fields->addFieldToTab('Root.Main',DropdownField::create('Player',_t(__CLASS__.'Player','Player'),['youtube'=>'You Tube','vimeo' => 'Vimeo', /*'dailymotion' => 'Dailymotion'*/])->setEmptyString('Player wählen')->displayIf('Type')->isEqualTo('Link')->end(),'VideoID');
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
				// case "dailymotion":
				//     $this->URL = "https://www.dailymotion.com/video/".$this->VideoID;
				//     $hash = json_decode(file_get_contents('https://api.dailymotion.com/video/'.$this->VideoID.'?fields=thumbnail_480_url'));
				//     $this->ThumbnailURL = $hash->thumbnail_large_url;

				// break;
			}
		}
	}

	public function onAfterWrite(){
		if ($this->FileID > 0){
			$this->File()->publishSingle();
		}
		parent::onAfterWrite();
	}

	public function getSrc(){
		if ($this->File()->exists()){
			return $this->File()->getURL();
		}
		return $this->URL;
	}
	
}