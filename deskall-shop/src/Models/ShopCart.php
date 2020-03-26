<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;

class ShopCart extends DataObject {

	
	private static $db = [
		'IP' => 'Varchar',
		'TotalPrice' => 'Currency',
		'Purchased' => 'Boolean(0)',
		'CurrentStep' => 'Varchar',
		//Customer Fields for save
		'Company' => 'Varchar',
		'Gender'  => 'Varchar',
		'Name' => 'Varchar',
		'FirstName' => 'Varchar',
		'Email' => 'Varchar',
		'Birthdate' => 'Date',
		'Street' => 'Varchar',
		'Address'  => 'Varchar',
		'Region'  => 'Varchar',
		'PostalCode'  => 'Varchar',
		'City'  => 'Varchar',
		'Country'  => 'Varchar',
		'Phone'  => 'Varchar',
		'DeliverySameAddress' => 'Boolean(1)',
		'DeliveryCompany' => 'Varchar',
		'DeliveryGender'  => 'Varchar',
		'DeliveryName' => 'Varchar',
		'DeliveryFirstName' => 'Varchar',
		'DeliveryStreet' => 'Varchar',
		'DeliveryAddress'  => 'Varchar',
		'DeliveryRegion'  => 'Varchar',
		'DeliveryPostalCode'  => 'Varchar',
		'DeliveryCity'  => 'Varchar',
		'DeliveryCountry'  => 'Varchar',
		'Additional' => 'Text' 
	];

	private static $has_one = [
		'Order' => ShopOrder::class,
		'Customer' => ShopCustomer::class
	];

	private static $many_many = [
		'Products' => Product::class,
	];

	private static $many_many_extraFields = [
		'Products' => ['SortOrder' => 'Int', 'Quantity' => 'Int']
	];

	private static $summary_fields = [
		'OnlineLabel' => '',
		'LastEdited' => 'Datum',
		'Summary' => 'Enthält',
		'printContact' => 'Kundendaten'
	];

	private static $searchable_fields = [
		'Name',
		'Email'
	];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Gender'] = _t(__CLASS__.'.Gender','Anrede');
		$labels['Name'] = _t(__CLASS__.'.Name','Name');
		$labels['FirstName'] = _t(__CLASS__.'.FirstName','Vorname');
		$labels['Email'] = _t(__CLASS__.'.Email','E-Mail');
		$labels['Address'] = _t(__CLASS__.'.Address','Adresse');
		$labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
		$labels['City'] = _t(__CLASS__.'.City','Stadt');
		$labels['Country'] = _t(__CLASS__.'.Country','Land');
		$labels['BillAddress'] = _t(__CLASS__.'.BillAddress','Adresse (Rechnung)');
		$labels['BillPostalCode'] = _t(__CLASS__.'.BillPostalCode','PLZ (Rechnung)');
		$labels['BillCity'] = _t(__CLASS__.'.BillCity','Stadt (Rechnung)');
		$labels['BillCountry'] = _t(__CLASS__.'.BillCountry','Land (Rechnung)');
		$labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
		$labels['Birthdate'] = _t(__CLASS__.'.Birthdate','Geburtsdatum');
		$labels['HouseNumber'] = _t(__CLASS__.'.HouseNumber','Haus-Nr.');
		
		return $labels;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->writeTotalPrice();
	}

	public function forTemplate(){
		return $this->renderWith('Includes/ShopCart');
	}

	public function Summary(){
		return $this->renderWith('Includes/ShopCartSummary');
	}

	public function isOnline(){
		$date = new DateTime('2 minutes ago');
		$edited = new DateTime($this->LastEdited);
		return $edited > $date;
	}

	public function OnlineLabel(){
		return ($this->isOnline()) ? DBHTMLText::create()->setValue('<div class="btn btn-primary">LIVE</div>') : null;
	}

	public function printContact(){
	    $html = '<p>'.$this->Gender.' '.$this->FirstName.' '.$this->Name.'<br/>';
	   
	    $html .= $this->Address.' '.$this->HouseNumber.'<br/>'
	    .$this->PostalCode.' - '.$this->City;
	    if ($this->Country){
	        $html .= '<br/>'.i18n::getData()->getCountries()[$this->Country];
	    }
	    $html .= '</p>'
	    .'<p><a href="mailto:'.$this->Email.'">'.$this->Email.'</a>'.'<br/>'
	    .$this->Phone.'</p>';
	    $o = new DBHTMLText();
	    $o->setValue($html);
	    return $o;
	}

	public function writeTotalPrice(){
		$price = 0;
		if ($this->Products()->exists()){
			foreach ($this->Products() as $product) {
				$price += $product->Price * $product->Quantity;
			}
		}
		
		$this->TotalPrice = $price;
	}

	public function ShopPage(){
		return ShopPage::get()->first();
	}

	public function Webshop(){
		return SiteConfig::current_site_config()->ShopPage();
	}

	public function countProducts(){
		$i = 0;
		foreach ($this->Products() as $p) {
			$i += $p->Quantity; 
		}
		return $i;
	}


	public function isEmpty(){
		return (!$this->Product()->exists());
	}
}