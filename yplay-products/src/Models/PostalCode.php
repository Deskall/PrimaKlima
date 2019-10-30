<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Subsite\Models\Subsite;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredField;

class PostalCode extends DataObject {

	private static $db = array(
	    'Code' => 'Varchar(255)',
	    'City' => 'Varchar(255)',
	    'StandardOffer' => 'Varchar(255)',
	    'AlternateOffer' => 'Varchar(255)',
	    'TVType' => 'Varchar(255)'
	);

	private static $singular_name = 'Postleitzahl';
	private static $plural_name = 'Postleitzahlen';

	private static $summary_fields = array(
	  'Code' => 'Postleitzahl',
	  'City' => 'Ortschaft',
	  'Availability' => 'Verfügbarkeit',
	  'TVType' => 'TV-Angebot',
	  'Link' => 'Website'
	);

	private static $has_one = array(
	    'Subsite'=> Subsite::class
	);

	// private static $belongs_many_many= [
	//     'unavailableProducts' => 'Product.unavailableCodes',
	//     'ownedProducts' => 'Product.PostalCodes',
	//     'ownedPackages' => 'Package'
	// ];

	public static $default_sort = 'Code';

	public function fieldLabels($includerelation = true){
	    $labels = parent::fieldLabels($includerelation);
	    $labels['Code'] = 'Postleitzahl';
	    $labels['City'] = 'Ortschaft';
	    $labels['StandardOffer'] = 'Standard Angebot';
	    $labels['AlternateOffer'] = 'Alternative Angebot';
	    $labels['TVType'] = 'TV Angebot';
	    // $labels['ownedPackages'] = 'Pakete';
	    // $labels['ownedProducts'] = 'Produkte';

	    return $labels;
	}

	public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    $fields->addFieldToTab('Root.Main', TextField::create('City','Ortschaft'));
	    $fields->addFieldToTab('Root.Main', DropdownField::create('StandardOffer',$this->fieldLabels()['StandardOffer'], array('Coax' => 'Cable', 'FTTH' => 'Fiber'))->setEmptyString('Bitte Typ auswählen'));
	    $fields->addFieldToTab('Root.Main', DropdownField::create('AlternateOffer',$this->fieldLabels()['AlternateOffer'], array('' => 'Keine', 'FTTH' => 'Fiber', 'DSL' => 'DSL'))->setEmptyString('Bitte Typ auswählen'));
	    $fields->addFieldToTab('Root.Main', DropdownField::create('TVType',$this->fieldLabels()['TVType'], array('DVBC' => 'DVB-C', 'IPTV' => 'IPTV'))->setEmptyString('Bitte Typ auswählen'));
	    
	    // $fields->addFieldToTab('Root.Main', TextField::create('URL','Externe Bestellung URL (Falls es keine Subsite gibt)'));

	    return $fields;
	}

	public function getCMSValidator(){
	    return new RequiredFields(array('Code','City','StandardOffer','TVType'));
	}

	public function CodeCity(){
	    return $this->Code." - ".$this->City;
	}

	public function Link(){
	    
	    if ($this->SubsiteID > 0){
	        if ($Subsite = DataObject::get_by_id('Subsite',$this->SubsiteID)){
	             return $Subsite->absoluteBaseURL();
	        }
	    }
	    return Director::absoluteBaseURL();
	}


	
}