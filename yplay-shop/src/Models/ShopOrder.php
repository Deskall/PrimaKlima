<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use setasign\Fpdi\Tcpdf\Fpdi;
use SilverStripe\Assets\Folder;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;

class ShopOrder extends DataObject{

	private static $singular_name = "Bestellung";

	private static $plural_name = "Bestellungen";

	private static $db = array(
		'Nummer' => 'Varchar(255)',
		'Name' => 'Varchar',
		'Vorname' => 'Varchar',
		'Email' => 'Varchar',
		'Gender'  => 'Varchar',
		'Address'  => 'Varchar',
		'HouseNumber' => 'Int',
		'PostalCode'  => 'Varchar',
		'City'  => 'Varchar',
		'Country'  => 'Varchar',
		'Phone'  => 'Varchar',
		'PhoneOption' => 'Varchar',
		'ExistingPhone' => 'Varchar',
		'WishPhone' => 'Varchar',
		'ExistingCustomer' => 'Int',
		'MonthlyPrice' => 'Currency',
		'UniquePrice' => 'Currency',
		'AGB' => 'Boolean(0)',
		'AGBMobile' => 'Boolean(0)',
		'PreviousProvider' => 'Varchar',
		'PaymentTyp' => 'Varchar',
		'Origin' => 'Varchar',
		'Comments' => 'Text',
		'Glasfaserdose' => 'Varchar',
		'UnknownGlasfaserdose' => 'Boolean'
	);

	private static $has_one = array(
		'Customer' => ShopCustomer::class	
	);

	private static $has_many = [
		'Items' => OrderItem::class
	];

	private static $summary_fields = array(
		'Nummer' => 'Rechnungsnummer',
		'NiceSubsite' => 'Website',
		'NiceOrder' => 'Übersicht',
		'Customer.printAddress' => 'Kunde',
		'Email' => 'Email',
		'Created.Nice' => 'Bestelldatum'
	);

	private static $cascade_deletes = [
		'Items'
	];

	private static $extensions = [
		'SubsiteFilterable'
	];

	private static $searchable_fields = [

		'Nummer' =>  array(
          "field" => TextField::class,
          "filter" => "PartialMatchFilter",
          "title" => 'Rechnungsnummer'
        ),
		'Customer.Name' => array(
          "field" => TextField::class,
          "filter" => "PartialMatchFilter",
          "title" => 'Kunden Name'
        ),
        'Customer.Email' => array(
          "field" => TextField::class,
          "filter" => "PartialMatchFilter",
          "title" => 'Kunden Email'
        )
	];

	private static $default_sort = "Created DESC";

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if (!$this->Nummer){
			$this->generateNummer();
		}
	}

	public function generateNummer(){
		$Config = $this->getSiteConfig();
		$last = ShopOrder::get()->sort('ID','Desc')->first();
		$increment = ($last) ? ($last->ID + 1) : 1;
		$this->Nummer = $Config->OrderNumberOffset.$increment;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		
		
		return $fields;
	}

	public function getOrderStatus(){

	}


	public function getSiteConfig(){
		return SiteConfig::current_site_config();
	}

	public function NiceOrder(){
		return $this->renderWith('Includes/ShopOrderSummary');
	}

	public function NiceSubsite(){
		return ($this->SubsiteID > 0) ? $this->Subsite()->Title : "YplaY";
	}

	public function NiceOrigin(){
		$origins = ['Empfehlung' => 'Empfehlung aus dem Umfeld', 'Google' => 'Google', 'Instagram' => 'Instagram','Twitter' => 'Twitter','Facebook' => 'Facebook','Linkedin' => 'Linkedin','Werbeplakat' => 'Werbeplakat','Zeitung' => 'Zeitung','Andere' => 'Andere'];
		return (isset($origins[$this->Origin])) ? $origins[$this->Origin] : 'Unbekannt';
	}

	public function NicePaymentTyp(){
		$types = ['Email' => 'E-Mail Rechnung', 'Paper' => 'Papier Rechnung (Fr. 2.50 / Mt.)', 'Lastschriftverfahren' => 'Lastschriftverfahren','DebitDirect' => 'Debit Direct (Postfinance)','eBanking' => 'eBanking Rechnung'];
		return (isset($types[$this->PaymentTyp])) ? $types[$this->PaymentTyp] : 'Unbekannt';
	}

	public function OrderHTML(){
		return $this->renderWith('Includes/ShopOrderData');
	}

	public function CustomerData(){
		return $this->renderWith('Includes/ShopCustomerData');
	}

	public function getTotalMonthlyPrice(){

	}


	public function getNiceMonthlyPrice(){
	    setlocale(LC_MONETARY, 'de_DE');
	    return ($this->MonthlyPrice) ? DBField::create_field('Varchar',money_format('%i',floatval($this->MonthlyPrice))) : null;
	}

	public function getNiceUniquePrice(){
	    setlocale(LC_MONETARY, 'de_DE');
	    return ($this->UniquePrice) ? DBField::create_field('Varchar',money_format('%i',floatval($this->UniquePrice))) : null;
	}

	// public function getOrderSubPrice(){
	//     setlocale(LC_MONETARY, 'de_DE');
	//     $price = $this->Quantity * $this->Product()->currentPrice();
	//     return DBField::create_field('Varchar',money_format('%i',$price));
	// }


	// public function getOrderPriceNetto(){
	//     $price = $this->Price * 100 / 107.7;
	//     setlocale(LC_MONETARY, 'de_DE');
	//     return DBField::create_field('Varchar',money_format('%i',$price));
	// }

	// public function getOrderMwSt(){
	//     $price = $this->Price - ($this->Price * 100 / 107.7);
	//     setlocale(LC_MONETARY, 'de_DE');
	//     return DBField::create_field('Varchar',money_format('%i',$price));
	// }


	public function sendEmail(){
	   
	    
	    $config = $this->getSiteConfig();

	    $email = new ShopOrderEmail($config,$this,$config->OrderEmailSender,$this->Email,$config->OrderEmailSubject, $config->OrderEmailBody);
	    // $email->setBCC($config->Email);

	    //Attchments
	    // $email->addAttachment(dirname(__FILE__).'/../../..'.$this->BillFile()->getURL(),'Rechnung.pdf');
	    // $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBFile()->getURL(),'AGB.pdf');

	    $email->send();

	}


}




