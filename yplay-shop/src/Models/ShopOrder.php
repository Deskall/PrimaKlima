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
		'Price' => 'Currency',
		'Name' => 'Varchar',
		'Vorname' => 'Varchar',
		'Email' => 'Varchar',
		'Gender'  => 'Varchar',
		'Address'  => 'Varchar',
		'PostalCode'  => 'Varchar',
		'City'  => 'Varchar',
		'Country'  => 'Varchar',
		'Phone'  => 'Varchar',
		'Quantity' => 'Int',
		'wasSeen' => 'Boolean(0)'
	);

	private static $has_one = array(
		'Customer' => ShopCustomer::class	
	);

	private static $summary_fields = array(
		'Nummer' => 'Rechnungsnummer',
		'Customer.printAddress' => 'Kunde',
		'Email' => 'Email',
		'Created.Nice' => 'Bestelldatum'
	);

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
		$Config = $this->getProductConfig();
		$last = ShopOrder::get()->sort('ID','Desc')->first();
		$increment = ($last) ? ($last->ID + 1) : 1;
		$this->Nummer = number_format ( $Config->OrderNumberOffset + $increment , 0 ,  "." ,  "." );
	}

	public function getCMSFields(){
		$fields = FieldList::create();
		$html = $this->renderWith('ShopOrderCMS');
		$fields->push(LiteralField::create('Order',$html));
		return $fields;
	}

	public function getOrderStatus(){

	}

	public function getProductConfig(){
		return ShopConfig::get()->first();
	}

	public function getSiteConfig(){
		return SiteConfig::current_site_config();
	}


	public function getOrderPrice(){
	    setlocale(LC_MONETARY, 'de_DE');
	    return DBField::create_field('Varchar',money_format('%i',$this->Price));
	}

	public function getOrderSubPrice(){
	    setlocale(LC_MONETARY, 'de_DE');
	    $price = $this->Quantity * $this->Product()->currentPrice();
	    return DBField::create_field('Varchar',money_format('%i',$price));
	}


	public function getOrderPriceNetto(){
	    $price = $this->Price * 100 / 107.7;
	    setlocale(LC_MONETARY, 'de_DE');
	    return DBField::create_field('Varchar',money_format('%i',$price));
	}

	public function getOrderMwSt(){
	    $price = $this->Price - ($this->Price * 100 / 107.7);
	    setlocale(LC_MONETARY, 'de_DE');
	    return DBField::create_field('Varchar',money_format('%i',$price));
	}


}




