<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;

class VideoObject extends DataObject{

    private static $table_name = 'VideoObject';

    private static $singular_name = 'Video';

    private static $plural_name = 'Video';

    private static $description = 'Video';

	private static $db = [
		'HTML' => 'HTMLText',
        'Title' => 'Text',
        'URL' => 'Varchar(255)'
	];

	private static $has_one = [
		'Parent' => VideoBlock::class,
		'File' => File::class
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);

		$labels['Title'] = _t(__CLASS__.".Title",'Titel');
		$labels['HTML'] = _t(__CLASS__.".HTML",'Inhalt');
		$labels['URL'] = _t(__CLASS__.".URL",'URL der Video');
		$labels['File'] = _t(__CLASS__.".File",'Datei');

		return $labels;
	}

	public function getSrc(){
		if ($this->File()){
			return $this->File()->getURL();
		}
		return $this->URL;
	}
	
}