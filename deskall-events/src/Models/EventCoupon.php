<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBText;

class EventCoupon extends DataObject {

	private static $db = array(
		'Code' => 'Varchar(255)',
		'Amount' => 'Int',
		'AmountType' => 'Varchar(255)',
		'Count'  => 'Int',
		'Used' => 'Int'
	);
	
	private static $singular_name = 'Gutschein';
	private static $plural_name = 'Gutscheine';

	private static $summary_fields = array(
		'Code' => 'Code',
		'NiceAmount' => 'Betrag',
		'Count'  => 'Verfügbar'
	);

	public function NiceAmount(){
		$amount = '';
		if( $this->AmountType == 'relative' ){
			$amount = $this->Amount.' %';
		}else{
			$amount = $this->Amount.' €';
		}
		return DBText::create()->setValue($amount);
	}


	public function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->removeByName('Used');
		$fields->addFieldToTab('Root.Main', ReadonlyField::create('Code', _t('COUPON.Code', 'Code')));
		$fields->addFieldToTab('Root.Main', NumericField::create('Count', _t('COUPON.Count', 'Verfügbar (wie oft)')));		
		$fields->addFieldToTab('Root.Main', NumericField::create('Amount', _t('COUPON.Amount', 'Betrag')));
		$fields->addFieldToTab('Root.Main', DropdownField::create('AmountType', _t('COUPON.AmountType', 'Art des Gutscheins'), array(
			'relative' => '%',
			'absolute' => '€',
		)));

		return $fields;
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if(!$this->Code){
			$this->Code = $this->generateCode();
		}
	}

	public function generateCode($length = 10){
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	public function DiscountPrice($originalPrice){
		$originalPrice = floatval($originalPrice);
		if ($this->AmountType == "relative"){
			$price = $originalPrice - ($originalPrice*($this->Amount)/100);
		}
		if ($this->AmountType == "absolute"){
			$price = $originalPrice - $this->Amount;
		}
		
		return $price;
	}

	public function isValid(){
		return $this->Count > 0;
	}

	
}
