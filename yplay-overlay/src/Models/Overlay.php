<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\SiteConfig\SiteConfig;


class Overlay extends DataObject{

	private static $singular_name = 'Overlay';
	private static $plural_name = 'Overlay';

	private static $db = [
		'Type' => 'Varchar(255)',
		'Title' => 'Varchar(255)',
		'Subtitle' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'CountDown' => 'Boolean(0)',
		'CountDownDate' => 'Datetime',
		'CloseButtonText' => 'Varchar(255)',
		'ValidButtonText' => 'Varchar(255)',
		'TriggerType' => 'Varchar(255)',
		'TriggerFrequency' => 'Varchar(255)',
		'TriggerTime' => 'Int',
		'BackgroundColor' => 'Varchar(255)',
		'CloseButtonBackground' => 'Varchar(255)',
		'ValidButtonBackground' => 'Varchar(255)'
	];

	private static $has_many = [
		'Pages' => Page::class
	];

	private static $has_one = [
		'BackgroundImage' => Image::class,
		'FormBlock' => OverlayForm::class
	];

	private static $extensions = [
		Versioned::class,
		'Linkable'
	];

    public function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Type'] = 'Art';
	    $labels['Subtitle'] = 'Untertitel';
	    $labels['Content'] = 'Inhalt';
	    $labels['CountDown'] = 'mit Rückwärts Zähler?';
	 	$labels['CountDownDate'] = 'Rückwärts bis';
	 	$labels['CloseButtonText'] = 'Titel des Buttons zum Schließen';
	 	$labels['ValidButtonText'] = 'Titel des Buttons zum Senden';
	 	$labels['TriggerType'] = 'Auslösungsart';
	    $labels['TriggerFrequency'] = 'Auslösung';
	 	$labels['TriggerTime'] = 'Zeit zum Auslösen (Sekunden)';
	 	$labels['BackgroundColor'] = 'Hintergrundfarbe';
	 	$labels['BackgroundImage'] = 'Hintergrundbild';
	 	$labels['CloseButtonBackground'] = 'Hintergrundfarbe des Buttons zum Schließen';
	 	$labels['ValidButtonBackground'] = 'Hintergrundfarbe des Buttons zum Senden';
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Type');
		$fields->removeByName('BackgroundColor');
		$fields->removeByName('BackgroundImage');
		$fields->removeByName('CloseButtonBackground');
		$fields->removeByName('ValidButtonBackground');
		$fields->removeByName('TriggerType');
		$fields->removeByName('TriggerTime');
		$fields->removeByName('TriggerFrequency');

		$fields->insertBefore('Title',DropdownField::create('Type', $this->fieldLabels()['Type'],['Newsletter' => 'Newsletter Anmeldung', 'Form' => 'Formular (Umfrage, Rezension)', 'Bewertung' => 'Bewertung', 'Text' => 'Inhalt (mit CountDown Möglichkeit)'])->setEmptyString('Bitte wählen'));
		
		$fields->addFieldsToTab('Root.Trigger', [
			DropdownField::create('TriggerType', $this->fieldLabels()['TriggerType'],['Time' => 'Zeit', 'Out' => 'Browser Abschluss / Seite wechseln'])->setEmptyString('Bitte wählen'),
			NumericField::create('TriggerTime',$this->fieldLabels()['TriggerTime'] )->displayIf('TriggerType')->isEqualTo('Time')->end(),
			DropdownField::create('TriggerFrequency', $this->fieldLabels()['TriggerFrequency'],['Once' => 'Einmal (per Session)', 'Always' => 'Immer'])->setEmptyString('Bitte wählen')
		]);
		$fields->fieldByName('Root.Trigger')->setTitle('Auslösung');
		$fields->addFieldsToTab('Root.Layout', [
			HTMLDropdownField::create('BackgroundColor',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->setDescription(_t(__CLASS__.'.BackgroundColorHelpText','wird als overlay anzeigen falls es ein Hintergrundbild gibt.'))->addExtraClass('colors'),
			UploadField::create('BackgroundImage',_t(__CLASS__.'.BackgroundImage','Hintergrundbild'))->setFolderName('Uploads/Overlays'),
			HTMLDropdownField::create('CloseButtonBackground',$this->fieldLabels()['CloseButtonBackground'],SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'),
			HTMLDropdownField::create('ValidButtonBackground',$this->fieldLabels()['ValidButtonBackground'],SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors')
		]);

		//Other display options
		$fields->fieldByName('Root.Main.Subtitle')->hideIf('Type')->isEqualTo('Form')->end();
		$fields->fieldByName('Root.Main.Content')->hideIf('Type')->isEqualTo('Form')->end();
		$fields->fieldByName('Root.Main.LinkableLinkID')->hideIf('Type')->isEqualTo('Form')->end();
		$fields->fieldByName('Root.Layout.ValidButtonBackground')->hideIf('Type')->isEqualTo('Form')->orIf('LinkableLinkID')->isGreaterThan(0)->end();
		$fields->fieldByName('Root.Main.ValidButtonText')->hideIf('Type')->isEqualTo('Form')->orIf('LinkableLinkID')->isGreaterThan(0)->end();
		$fields->fieldByName('Root.Main.FormBlockID')->displayIf('Type')->isEqualTo('Form')->end();

		return $fields;
	}
}