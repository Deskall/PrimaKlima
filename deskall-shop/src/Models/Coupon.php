<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;

class Coupon extends DataObject {

	private static $db = array(
		'Code' => 'Varchar(255)',
		'Amount' => 'Int',
		'AmountType' => 'Varchar(255)',
		'Count'  => 'Int',
		'Used' => 'Int'
	);


	private static $summary_fields = array(
		'Code' => 'Code',
		'NiceAmount' => 'Betrag',
		'Count'  => 'Verfügbar'
	);

	public function NiceAmount(){
		if( $this->AmountType == 'relative' ){
			return $this->Amount.' %';
		}else{
			return $this->Amount.' €';
		}

	}


	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Used');
		$fields->addFieldToTab('Root.Main', TextField::create('Code', _t('COUPON.Code', 'Code')));
		$fields->addFieldToTab('Root.Main', NumericField::create('Count', _t('COUPON.Count', 'Verfügbar (wie oft)')));		
		$fields->addFieldToTab('Root.Main', NumericField::create('Amount', _t('COUPON.Amount', 'Betrag')));
		$fields->addFieldToTab('Root.Main', DropdownField::create('AmountType', _t('COUPON.AmountType', 'Art des Gutscheins'), array(
			'relative' => '%',
			'absolute' => '€',
		)));



		return $fields;
	}



	private static $singular_name = 'Gutschein';
	private static $plural_name = 'Gutscheine';


}
