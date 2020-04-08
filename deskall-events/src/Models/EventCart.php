<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBCurrency;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\FieldType\DBField;

class EventCart extends DataObject {

	
	private static $db = [
		'IP' => 'Varchar',
		'TotalPrice' => 'Currency',
		'DiscountPrice' => 'Currency',
		'PaymentMethod' => 'Varchar',
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
		'Additional' => 'Text' 
	];

	private static $has_one = [
		'Order' => EventOrder::class,
		'Customer' => Participant::class,
		'Voucher' => Coupon::class,
		'Date' => EventDate::class
	];

	
	
	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->writeTotalPrice();
		$this->writeFullTotalPrice();
	}

	public function Summary(){
		return $this->renderWith('Includes/EventCartSummary');
	}

	public function NiceCountry(){
		return ($this->Country) ? i18n::getData()->getCountries()[$this->Country] : null;
	}

	public function getPaymentResource(){
		switch ($this->PaymentMethod){
			case "bill":
				$type = "Rechnung";
			break;
			case "cash":
				$type = "Bargeld";
			break;
			case "creditcard":
				$type = "PayPal / Kreditkarte";
			break;
			default:
				$type = "unbekannt";
			break;
		}
	    return DBField::create_field('Varchar', $type);
	}

	public function printAddress(){
        $html = '<p>';
        if ($this->Company){
            $html .= $this->Company.'<br/>';
        }
        $html .= $this->Gender.' '.$this->FirstName.' '.$this->Name.'<br/>';
        $html .= $this->Street.'<br/>';
        if ($this->Address){
            $html .= $this->Address.'<br/>';
        }
        $html .= $this->PostalCode.' - '.$this->City.'<br/>';
        if ($this->Country){
            $html .= i18n::getData()->getCountries()[strtolower($this->Country)];
        }
        $html .= '</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

	public function printContact(){
	    $html = '<p>'.$this->Gender.' '.$this->FirstName.' '.$this->Name.'<br/>';
	   
	    $html .= $this->Street.' '.$this->Address.'<br/>'
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
		if ($this->Date()->exists()){
			$price += $this->Date()->Price;
		}
		if ($this->Voucher()->exists()){
			if ($this->Voucher()->AmountType == "relative"){
				$discount = $price * floatval($this->Voucher()->Amount) / 100 ;
			}
			else{
				$discount = $this->Voucher()->Amount;
			}
			$this->DiscountPrice = $discount;
			$price -= $discount;
		}
		
		$this->TotalPrice = $price;
	}


	public function SiteConfig(){
		return SiteConfig::current_site_config();
	}

	public function MwSt(){
		$mwst = $this->TotalPrice * floatval($this->SiteConfig()->MwSt) / 100;
		return DBCurrency::create()->setValue($mwst);
	}

}