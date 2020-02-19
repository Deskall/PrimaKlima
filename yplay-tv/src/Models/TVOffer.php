<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;

class TVOffer extends DataObject{

	private static $singular_name = 'TV-Angebot';
	private static $plural_name = 'TV-Angebote';

	private static $db = [
		'Title' => 'Varchar',
		'Inhalt' => 'HTMLText',
		'TVOffer' => 'Enum("DVBC,IPTV","DVBC")'
	];

	private static $default_sort = ['Title' => 'ASC'];

	private static $extensions = [
		'Sortable',
		'Activable',
		'Linkable'
	];

	private static $has_one = ['Image' => Image::class];

	private static $summary_fields = ['Title','TVOffer'];

	public function fieldLabels($includerelations = true){
		$labels = parent::fieldLabels($includerelations);
		$labels['Title'] = _t(__CLASS__.'.Title','Titel');
		$labels['Inhalt'] = _t(__CLASS__.'.Inhalt','Beschreibung');
		$labels['Image'] = _t(__CLASS__.'.Image','Bild');
		$labels['TVOffer'] = _t(__CLASS__.'.TVOffer','TV Angebot');
		return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		return $fields;
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		
	}

}