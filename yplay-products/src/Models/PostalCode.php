<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Control\Director;

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

	private static $summary_fields = [
	  'Code',
	  'City',
	  'StandardOffer',
	  'TVType' => 'TV-Angebot'
	];

	private static $has_one = [
	    'Subsite'=> Subsite::class
	];

	// private static $belongs_many_many= [
	//     'unavailableProducts' => 'Product.unavailableCodes',
	//     'ownedProducts' => 'Product.PostalCodes',
	//     'ownedPackages' => 'Package'
	// ];

	private static $default_sort = 'Code';

	public function fieldLabels($includerelation = true){
	    $labels = parent::fieldLabels($includerelation);
	    $labels['Code'] = 'Postleitzahl';
	    $labels['City'] = 'Ortschaft';
	    $labels['StandardOffer'] = 'Standard Angebot';
	    $labels['AlternateOffer'] = 'Alternative Angebot';
	    $labels['TVType'] = 'TV Angebot';
	    $labels['Subsite'] = 'Website';
	    // $labels['ownedPackages'] = 'Pakete';
	    // $labels['ownedProducts'] = 'Produkte';

	    return $labels;
	}

	public function getCMSFields() {
	    $fields = parent::getCMSFields();
	    $fields->addFieldToTab('Root.Main', DropdownField::create('SubsiteID',$this->fieldLabels()['Subsite'],Subsite::get()->map('ID','Title'))->setEmptyString('YplaY'));
	    $fields->addFieldToTab('Root.Main', DropdownField::create('StandardOffer',$this->fieldLabels()['StandardOffer'], array('Coax' => 'Cable', 'FTTH' => 'Fiber'))->setEmptyString('Bitte Typ auswählen'));
	    $fields->addFieldToTab('Root.Main', DropdownField::create('AlternateOffer',$this->fieldLabels()['AlternateOffer'], array('' => 'Keine','Coax' => 'Cable','FTTH' => 'Fiber', 'DSL' => 'DSL'))->setEmptyString('Bitte Typ auswählen'));
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