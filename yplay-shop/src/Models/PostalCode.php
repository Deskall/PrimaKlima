<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Control\Director;
use SilverStripe\Forms\CheckboxField;

class PostalCode extends DataObject {

	private static $db = array(
	    'Code' => 'Varchar(255)',
	    'City' => 'Varchar(255)',
	    'StandardOffer' => 'Varchar(255)',
	    'AlternateOffer' => 'Varchar(255)',
	    'TVType' => 'Varchar(255)',
	    'YplaY' => 'Boolean(0)',
	    'Externe' => 'Boolean(0)',
	    'URL' => 'Varchar',
	    'OldID' => 'Int',
	    'Layer' => 'Varchar',
	    'Netz' => 'Varchar',
	);

	private static $singular_name = 'Postleitzahl';
	private static $plural_name = 'Postleitzahlen';

	private static $summary_fields = [
	  'Code',
	  'City',
	  'Layer',
	  'Netz',
	  'StandardOffer',
	  'AlternateOffer',
	  'TVType' => 'TV-Angebot',
	  'URL' => 'Externe Weiterleitung',
	  'Shop.Title' => 'Shop'
	];

	private static $has_one = [
	    'Subsite'=> Subsite::class,
	    'Shop' => Shop::class
	];

	private static $belongs_many_many= [
	    'Actions' => PriceDiscount::class,
	    'Products' => Product::class
	];

	private static $default_sort = 'Code';

	public function fieldLabels($includerelation = true){
	    $labels = parent::fieldLabels($includerelation);
	    $labels['Code'] = 'Postleitzahl';
	    $labels['City'] = 'Ortschaft';
	    $labels['StandardOffer'] = 'Standard Angebot';
	    $labels['AlternateOffer'] = 'Alternative Angebot';
	    $labels['TVType'] = 'TV Angebot';
	    $labels['Subsite'] = 'Website';
	    $labels['YplaY'] = 'Diese Ortschaft ist auch für YplaY verfügbar';
	    $labels['Externe'] = 'Wird zu einer externe Website weiterleiten';
	    $labels['URL'] = 'URL der externe Website';
	    $labels['Shop'] = 'Dediziert Partner';
	    // $labels['ownedPackages'] = 'Pakete';
	    // $labels['ownedProducts'] = 'Produkte';

	    return $labels;
	}

	public function getCMSFields() {
		// foreach (PostalCode::get() as $p) {
		// 	$p->write();
		// }
	    $fields = parent::getCMSFields();
	    $fields->removeByName('OldID');
	    $fields->FieldByName('Root.Main')->setTitle('Ortschaft Angaben');
	    $fields->addFieldToTab('Root.Main', DropdownField::create('Layer',$this->fieldLabels()['Layer'],['Layer 1' => 'Layer 1', 'Layer 2' => 'Layer 2', 'Layer 1&2' => 'Layer 1&2'])->setEmptyString('Bitte auswählen')->hideIf('Externe')->isChecked()->end());
	    $fields->addFieldToTab('Root.Main', DropdownField::create('SubsiteID',$this->fieldLabels()['Subsite'],Subsite::get()->map('ID','Title'))->setEmptyString('YplaY')->hideIf('Externe')->isChecked()->end());
	    $fields->addFieldToTab('Root.Main', CheckboxField::create('Externe',$this->fieldLabels()['Externe']));
	    $fields->addFieldToTab('Root.Main', TextField::create('URL',$this->fieldLabels()['URL'])->displayIf('Externe')->isChecked()->end());
	  	$fields->addFieldToTab('Root.Main', CheckboxField::create('YplaY',$this->fieldLabels()['YplaY'])->displayIf('SubsiteID')->isNotEmpty()->end());
	    $fields->addFieldToTab('Root.Main', DropdownField::create('StandardOffer',$this->fieldLabels()['StandardOffer'], array('Cable' => 'Cable', 'Fiber' => 'Fiber'))->setEmptyString('Bitte Typ auswählen')->hideIf('Externe')->isChecked()->end());
	    $fields->addFieldToTab('Root.Main', DropdownField::create('AlternateOffer',$this->fieldLabels()['AlternateOffer'], array('' => 'Keine','Cable' => 'Cable','Fiber' => 'Fiber', 'DSL' => 'DSL'))->setEmptyString('Bitte Typ auswählen')->hideIf('Externe')->isChecked()->end());
	    $fields->addFieldToTab('Root.Main', DropdownField::create('TVType',$this->fieldLabels()['TVType'], array('DVBC' => 'DVB-C', 'IPTV' => 'IPTV'))->setEmptyString('Bitte Typ auswählen')->hideIf('Externe')->isChecked()->end());
	    $fields->addFieldToTab('Root.Main', DropdownField::create('ShopID',$this->fieldLabels()['Shop'], Shop::get()->map('ID','Title'))->setEmptyString('Bitte Typ auswählen')->hideIf('Externe')->isChecked()->end());
	    
	    // $fields->addFieldToTab('Root.Main', TextField::create('URL','Externe Bestellung URL (Falls es keine Subsite gibt)'));

	    return $fields;
	}

	public function getCMSValidator(){
	    return new RequiredFields(array('Code','City'));
	}

	public function CodeCity(){
	    return $this->Code." - ".$this->City;
	}

	public function Link(){
	    if ($this->Externe){
	    	return $this->URL;
	    }
	    if ($this->SubsiteID > 0){
	        if ($Subsite = DataObject::get_by_id(Subsite::class,$this->SubsiteID)){
	             return $Subsite->absoluteBaseURL();
	        }
	    }
	    return Director::absoluteBaseURL();
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		// if ($this->SubsiteID == 0){
		// 	$this->YplaY = false;
		// }
		if (!$this->Shop()->exists()){
			$shop = Shop::get()->filter('PLZ',$this->Code)->first();
			if ($shop){
				$this->ShopID = $shop->ID;
			}
		}
	}


	
}