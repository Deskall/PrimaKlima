<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;

class ShopCart extends DataObject {

	
	private static $db = [
		'IP' => 'Varchar',
		'TotalMonthlyPrice' => 'Currency',
		'TotalUniquePrice' => 'Currency',
		'Purchased' => 'Boolean(0)',
		'CurrentStep' => 'Varchar',
		//Customer Fields for save
		'Gender'  => 'Varchar',
		'Name' => 'Varchar',
		'FirstName' => 'Varchar',
		'Email' => 'Varchar',
		'Birthdate' => 'Date',
		'Address'  => 'Varchar',
		'HouseNumber' => 'Int',
		'PostalCode'  => 'Varchar',
		'City'  => 'Varchar',
		'Country'  => 'Varchar',
		'Phone'  => 'Varchar',
		'BillSameAddress' => 'Boolean(1)',
		'BillAddress'  => 'Varchar',
		'BillPostalCode'  => 'Varchar',
		'BillCity'  => 'Varchar',
		'BillCountry'  => 'Varchar',
		'PhoneOption' => 'Varchar',
		'ExistingPhone' => 'Varchar',
		'WishPhone' => 'Varchar',
		'ExistingCustomer' => 'Boolean(0)',
		'Availability' => 'Varchar'
	];

	private static $has_one = [
		'Order' => ShopOrder::class,
		'Package' => Package::class,
		'Customer' => ShopCustomer::class
	];

	private static $many_many = [
		'Products' => Product::class,
		'Options' => ProductOption::class
	];

	private static $many_many_extraFields = [
		'Products' => ['SortOrder' => 'Int', 'Quantity' => 'Int'],
		'Options' => ['SortOrder' => 'Int', 'Quantity' => 'Int']
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

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('IP');
		return $fields;
	}

	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->writeTotalMonthlyPrice();
		$this->writeTotalUniquePrice();
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

	public function writeTotalMonthlyPrice(){
		$price = 0;
		if ($this->Package()->exists()){
			$price += ($this->Package()->getActionMonthlyPrice()) ? $this->Package()->getActionMonthlyPrice() : $this->Package()->getMonthlyPrice();
		}
		if ($this->Products()->exists()){
			foreach ($this->Products() as $product) {
				$price += ($product->getActionMonthlyPrice() ) ? $product->getActionMonthlyPrice()  * $product->Quantity : $product->getMonthlyPrice() * $product->Quantity;
			}
		}
		if ($this->Options()->filter('RecurringPrice',1)->exists()){
			foreach ($this->Options() as $product) {
				$price += ($product->getActionMonthlyPrice() ) ? $product->getActionMonthlyPrice()  * $product->Quantity : $product->getMonthlyPrice() * $product->Quantity;
			}
		}
		$this->TotalMonthlyPrice = $price;
	}

	public function PrintMonthlyPrice(){
		return "CHF ".number_format($this->TotalMonthlyPrice,2)." /Mt.";
	}

	public function writeTotalUniquePrice(){
		$price = 0;
		if ($this->Package()->exists()){
			$price += $this->Package()->getPriceUnique();
			$price += $this->Package()->getFees();
		}
		if ($this->Products()->exists()){
			foreach ($this->Products() as $product) {
				$price += $product->getPriceUnique() * $product->Quantity;
				$price += $product->getFees() * $product->Quantity;
			}
		}
		if ($this->Options()->exists()){
			foreach ($this->Options() as $product) {
				if (!$product->RecurringPrice){
					$price += $product->getMonthlyPrice() * $product->Quantity;
				}
				$price += $product->getPriceUnique() * $product->Quantity;
				$price += $product->getFees() * $product->Quantity;
			}
		}

		$this->TotalUniquePrice = $price;
	}

	public function PrintUniquePrice(){
		return "CHF ".number_format($this->TotalUniquePrice,2);
	}

	public function hasCategory($code){
		$confirm = false;
		if ($this->Package()->exists()){
			foreach ($this->Package()->Products() as $p) {
				if ($p->Category()->Code == $code){
					$confirm = true;
					break;
				}
			}
		}
		if ($this->Products()->exists() && !$confirm){
			foreach ($this->Products() as $p) {
				if ($p->Category()->Code == $code){
					$confirm = true;
					break;
				}
			}
		}
		return $confirm;
	}

	public function hasPremiumSender(){
		if ($this->Options()->exists()){
			$paytvpackage = ProductOption::get()->filter('ProductCode','pay-tv-pakete')->first();
			if ($paytvpackage){
				foreach ($this->Options() as $option) {
					if ($option->Group()->exists() && $option->GroupID == $paytvpackage->ID){
						return true;
					}
				}
			}
		}
		return false;
	}

	// public function requireCategory($code){
	// 	$required = false;
		
	// 	if ($this->Products()->exists()){
	// 		$categories = DataList::create();
	// 		foreach ($this->Products() as $p) {
	// 			$categories->add($p->Category());
	// 		}
			
	// 		$dependencies = ProductDependency::create()->filter('ParentID',$categories->column('ID'));
	// 		//First check global dependencies
	// 		$globalDependencies = $dependencies->filter('isGlobal',1);
	// 		if ($globalDependencies->exists()){
	// 			foreach ($globalDependencies as $gd){
					
	// 			}
	// 		}
			

	// 		$request = Injector::inst()->get(HTTPRequest::class);
	// 		$session = $request->getSession();
	// 		$plzID = $session->get('active_plz')
		
			
				
	// 			$p->Category()->Dependencies()->filter()
	// 		}
	// 	}
		
	// 	return $required;
		
	// }

	public function isEmpty(){
		return (!$this->Package()->exists() && !$this->Products()->exists() && !$this->Options()->exists());
	}

	public function getSiteConfig(){
		return SiteConfig::current_site_config();
	}
}