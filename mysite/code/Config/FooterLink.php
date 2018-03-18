<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;


class FooterLink extends DataObject{

	private static $db = [
		'Icon' => 'Varchar(255)',
		'Type' => 'Varchar(255)'
	];

	private static $has_one = [
		'Parent' => 'FooterBlock'
	];

	private static $extensions = [
		'Activable',
        'Linkable',
        'Sortable'
	];

	private static $summary_fields = [
		'DisplayLink'
	];

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	 
	    $labels['DisplayLink'] = _t(__CLASS__.'.Link','Link');
	   
	 
	    return $labels;
	}

	private static $icons = [
		'chevron-right' => 'chevron-right',
		'home' => 'home',
		'mail' => 'Email',
		'receiver' => 'Telefon',
		'location' => 'Marker',
		'user' => 'Person',
		'users' => 'Personen',
		'tag' => 'Tag',
		'calendar' => 'Kalender',
		'search' => 'Suche',
		'list' => 'Liste',
		'lock' => 'Private',
		'facebook' => 'facebook',
		'twitter' => 'twitter',
		'google-plus' => 'google-plus',
		'linkedin' => 'linkedin',
		'xing' => 'xing'
	];

	public function getCMSFields(){
		$fields = parent::getCMSFields();

        $fields->removeByName('ParentID');
        $fields->removeByName('Type');
        //$fields->addFieldToTab('Root.Main',DropdownField::create('Type', 'LinkTyp',self::$block_types)->setEmptyString('Bitte Typ auswählen'),'Content');
        $fields->addFieldToTab('Root.Main',DropdownField::create('Icon',_t(__CLASS__. '.Icon','Icon'),$this->getTranslatedSourceFor(__CLASS__,'icons'))->setEmptyString(_t(__CLASS__. '.IconLabel','Icon hinzufügen')));
        return $fields;
    }

    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('icons') as $key => $value) {
          $entities[__CLASS__.".icons_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
