<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Overlay extends DataObject{

	private static $singular_name = 'Overlay';
	private static $plural_name = 'Overlay';

	private static $db = [
		'Type' => 'Varchar(255)',
		'Title' => 'Varchar(255)',
		'Subtitle' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'CountDown' => 'Boolean(0)',
		'CountDownDate' => 'Datetime'
	];


	private static $extensions = [
		Versioned::class
	];


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Type'] = 'Art';
	    $labels['Subtitle'] = 'Untertitel';
	    $labels['Content'] = 'Inhalt';
	    $labels['CountDown'] = 'mit Rückwärts Zähler?';
	 	$labels['CountDownDate'] = 'Rückwärts bis';
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->fieldByName('Root.Main.Type')->setSource(['Newsletter' => 'Newsletter Anmeldung', 'Form' => 'Formular', 'Bewertung' => 'Bewertung', 'Text' => 'Inhalt (mit CountDown Möglichkeit)']);

		return $fields;
	}
}