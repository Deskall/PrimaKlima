<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\SiteConfig\SiteConfig;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;

class Overlay extends DataObject{

	private static $singular_name = 'Overlay';
	private static $plural_name = 'Overlay';

	private static $db = [
		'Type' => 'Varchar(255)',
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'AGBText' => 'HTMLText',
		'EmailSubject' => 'Varchar(255)',
		'EmailSender' => 'Varchar(255)',
		'EmailReceiver' => 'Varchar(255)',
		'EmailText' => 'HTMLText',
		'ReplyTo' => 'Varchar(255)',
		'Footer' => 'HTMLText',
		'CountDown' => 'Boolean(0)',
		'CountDownDate' => 'Datetime',
		'CloseButtonText' => 'Varchar(255)',
		'ValidButtonText' => 'Varchar(255)',
		'TriggerType' => 'Varchar(255)',
		'TriggerFrequency' => 'Varchar(255)',
		'TriggerTime' => 'Int',
		'BackgroundColor' => 'Varchar(255)',
		'CloseButtonBackground' => 'Varchar(255)',
		'ValidButtonBackground' => 'Varchar(255)',
	];

	private static $has_many = [
		'Pages' => Page::class
	];

	private static $has_one = [
		'BackgroundImage' => Image::class,
		'FormBlock' => OverlayForm::class,
		'RedirectPage' => Page::class
	];

	private static $extensions = [
		Versioned::class,
		'Linkable'
	];

	private static $defaults = [
		'CloseButtonText' => 'Zurück',
		'ValidButtonText' => 'Einverstanden',
		'TriggerType' => 'Time',
		'TriggerTime' => '5',
		'TriggerFrequency' => 'Once'
	];


    public function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Type'] = 'Art';
	    $labels['Content'] = 'Inhalt';
	    $labels['AGBText'] = 'Datenschutz Einverständnis';
	    $labels['EmailSender'] = 'Email Betreff';
	    $labels['EmailSender'] = 'Email Absender';
	    $labels['EmailReceiver'] = 'Email Empfänger';
	 	$labels['EmailText'] = 'Email Text';
	 	$labels['Footer'] = 'Email Footer Text';
	 	$labels['ReplyTo'] = 'Email Antwort an';
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
	 	$labels['RedirectPage'] = 'Erfolgreich Einreichung Seite';
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Type');
		$fields->removeByName('BackgroundColor');
		$fields->removeByName('BackgroundImage');
		$fields->removeByName('CloseButtonBackground');
		$fields->removeByName('TriggerType');
		$fields->removeByName('TriggerTime');
		$fields->removeByName('TriggerFrequency');
		$fields->removeByName('CountDownDate');

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

		$fields->insertAfter('CountDown', Wrapper::create(DatetimeField::create('CountDownDate', $this->fieldLabels()['CountDownDate']))->displayIf('CountDown')->isChecked()->end());


		//Other display options
		$fields->fieldByName('Root.Main.CountDown')->displayIf('Type')->isEqualTo('Text')->end();
		$fields->fieldByName('Root.Main.Content')->hideIf('Type')->isEqualTo('Form')->end();
		$fields->fieldByName('Root.Main.AGBText')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.ValidButtonText')->displayIf('Type')->isEqualTo('Newsletter')->end();
		$fields->fieldByName('Root.Layout.ValidButtonBackground')->hideUnless('Type')->isEqualTo('Newsletter')->end();
		$fields->fieldByName('Root.Main.FormBlockID')->displayIf('Type')->isEqualTo('Form')->end();
		$fields->fieldByName('Root.Main.RedirectPageID')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.EmailSender')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.EmailReceiver')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.EmailSubject')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.EmailText')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.Footer')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();
		$fields->fieldByName('Root.Main.ReplyTo')->displayIf('Type')->isEqualTo('Newsletter')->orIf('Type')->isEqualTo('Bewertung')->end();

		//Pages
		$fields->fieldByName('Root.Pages')->setTitle('Verknüpfene Seiten');
		$fields->fieldByName('Root.Pages.Pages')->getConfig()->removeComponentsByType([GridFieldAddNewButton::class]);

		return $fields;
	}

	public function validate() {
        $result = parent::validate();

        if(!$this->Type) {
            $result->addError('Bitte Art auswählen');
        }

        return $result;
    }

    public function getCMSEditLink()
        {
            $admin = Injector::inst()->get(OverlayAdmin::class);

            // Classname needs to be passeed as an action to ModelAdmin
            $classname = str_replace('\\', '-', $this->ClassName);

            return Controller::join_links(
                $admin->Link($classname),
                "EditForm",
                "field",
                $classname,
                "item",
                $this->ID,
                "edit"
            );
        }

    public function getParsedString($string, $url) {
        $absoluteBaseURL = $this->BaseURL();
        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$viewLink'      => Controller::join_links(
                $absoluteBaseURL,
                $this->getCMSEditLink()
            ),
            '$exportLink'    => Controller::join_links(
                $absoluteBaseURL,
                'admin/overlay/rates'
            ),
            '$URL' => $url,
        );
        
        return str_replace(array_keys($variables), array_values($variables), $string);
    }
}