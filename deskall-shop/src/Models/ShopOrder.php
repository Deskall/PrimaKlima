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
use SilverStripe\ORM\FieldType\DBHTMLText;

class ShopOrder extends DataObject{

	private static $singular_name = "Rechnung";

	private static $plural_name = "Rechnungen";

	private static $db = array(
		'Nummer' => 'Varchar(255)',
		'isPaid' => 'Boolean',
		'PaymentType' => 'Varchar',
		'Price' => 'Currency',
		'Name' => 'Varchar',
		'Vorname' => 'Varchar',
		'Email' => 'Varchar',
		'Company' => 'Varchar',
		'Address'  => 'Varchar',
		'PostalCode'  => 'Varchar',
		'City'  => 'Varchar',
		'Country'  => 'Varchar',
		'Phone'  => 'Varchar',
		'AGB' => 'Boolean(0)',
		'StartValidity' => 'Date',
		'EndValidity' => 'Date',
		'RemainingOffers' => 'Int',
		'isActive' => 'Boolean(0)',
		'PayPalOrderID' => 'Varchar',
		'Credits' => 'Int'
	);

	private static $has_one = array(
		'Customer' => JobGiver::class,
		'BillFile'  => File::class,
		'ReceiptFile' => File::class,
		'Voucher' => Coupon::class,
		'Product' => Package::class,
		'Option' => PackageOption::class
	);

	private static $summary_fields = array(
		'Nummer' => 'Rechnungsnummer',
		'NiceAddress' => 'Kunde',
		'Email' => 'Email',
		'PaidStatus' => 'Bezahlt',
		'PaymentResource' => 'Zahlungsmethod',
		'Created.Nice' => 'Bestelldatum',
		'Documents' => 'Dokumente'
	);

	private static $searchable_fields = [

		'Nummer' =>  array(
          "field" => TextField::class,
          "filter" => "PartialMatchFilter",
          "title" => 'Rechnungsnummer'
        ),
		'Customer.ContactPersonSurname' => array(
          "field" => TextField::class,
          "filter" => "PartialMatchFilter",
          "title" => 'Kunden Name'
        ),
		'Company' => array(
          "field" => TextField::class,
          "filter" => "PartialMatchFilter",
          "title" => 'Firma'
        )
	];

	private static $default_sort = "Created DESC";

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if (!$this->Nummer){
			$this->generateNummer();
		}
		if ($this->Created == $this->LastEdited){
			$this->Initiate();
		}
		if ($this->RemainingOffers == 0 && $this->Product()->NumOfAds > 0){
			$this->isActive = false;
		}
	}

	public function Initiate(){
		if ($this->isPaid){
			$this->isActive = true;
		}
		if ($this->Product()->ClassName == Package::class){
			$this->RemainingOffers = $this->Product()->NumOfAds;
		}
		if ($this->Product()->ClassName == MatchingToolPackage::class){
			$this->Credits = $this->Product()->Credits;
		}
	}

	public function generateNummer(){
		$Config = $this->getSiteConfig();
		$last = ShopOrder::get()->sort('ID','Desc')->first();
		$increment = ($last) ? ($last->ID + 1) : 1;
		$this->Nummer = number_format ( $Config->OrderNumberOffset + $increment , 0 ,  "." ,  "." );
	}

	public function getCMSFields(){
		$fields = FieldList::create();
		$this->Initiate();
		$html = $this->renderWith('ShopOrderCMS');
		$fields->push(LiteralField::create('Order',$html));
		return $fields;
	}

	public function NiceAddress($full = true){
	    $html = '<p>';
	    if ($this->Company){
	        $html .= $this->Company.'<br/>';
	    }
	    if ($this->Name){
	        $html .= $this->Vorname.' '.$this->Name.'<br/>';
	    }
	    if ($this->Address){
	        $html .= $this->Address.'<br/>';
	    }
	    
	    $html .= $this->PostalCode.' - '.$this->City.'</p>';
	    if ($full){
	        $html .= '<p><a href="mailto:'.$this->Email.'">'.$this->Email.'</a>'.'<br/>'
	    .$this->Phone.'</p>';
	    }
	    $o = new DBHTMLText();
	    $o->setValue($html);
	    return $o;
	}

	public function canMarkAsPaid(){
		if ($this->PaymentType == "bill" && !$this->isPaid){
			return true;
		}
		return false;
	}
	
	public function MarkAsPaid(){
		$this->isPaid = true;
		$this->Initiate();
		$this->generateQuittungPDF();
		$this->write();
		$this->sendConfirmationEmail();
	}

	public function getPeriod(){
		if ($this->isPaid){
			$period = "vom ".$this->StartValidity." bis ".$this->EndValidity;
		}
		return "-";
	}

	public function StartValidityPeriod(){
		$start = new \DateTime();
		$this->StartValidity = $start->format('Y-m-d H:i');
		//Laufzeit
		$period = '+'.$this->Product()->RunTime;
		$currency = $this->Product()->RunTimeCurrency;
		if ($this->Product()->Runtime > 1){
			$currency .= 's';
		}
		$period .= ' '.$currency;
		$end = $start->modify($period);
		$this->EndValidity = $end->format('Y-m-d H:i');
	}

	public function getPaymentResource(){
		switch ($this->PaymentType){
			case "bill":
				$type = "Rechnung";
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

	public function getPaidStatus(){
		$paid = ($this->isPaid) ? "Ja" : "Nein";
	    return DBField::create_field('Varchar', $paid);
	}

	public function getOrderStatus(){

	}

	public function isMatchingOrder(){

	}

	public function getSiteConfig(){
		return SiteConfig::current_site_config();
	}

	public function getDocuments(){
		return ($this->isPaid) ? $this->getReceipt() : $this->getBill();
	}

	public function getBill(){
		// $this->generatePDF();
		$html = ($this->BillFile()->exists()) ? $this->BillFile()->forTemplate() : '(keine)';
		return DBField::create_field('HTMLText',$html);
	}

	public function getFinalPrice(){
		if ($this->Voucher()->exists()){
			return $this->Voucher()->DiscountPrice($this->Price);
		}
		return $this->Price;
	}

	public function getOrderPrice(){
	    setlocale(LC_MONETARY, 'de_DE');
	    return DBField::create_field('Varchar',money_format('%i',$this->getFinalPrice()));
	}

	public function getOrderSubPrice(){
	    setlocale(LC_MONETARY, 'de_DE');
	    $price = $this->Price;
	    return DBField::create_field('Varchar',money_format('%i',$price));
	}


	public function getOrderPriceNetto(){
	    // $price = $this->Price * 100 / 107.7;
	    $price = $this->getFinalPrice();
	    setlocale(LC_MONETARY, 'de_DE');
	    return DBField::create_field('Varchar',money_format('%i',$price));
	}

	public function getOrderMwSt(){
	    // $price = $this->Price - ($this->Price * 100 / 107.7);
	    $price = 0;
	    setlocale(LC_MONETARY, 'de_DE');
	    return DBField::create_field('Varchar',money_format('%i',$price));
	}

	public function getReceipt(){
		// $this->generateQuittungPDF();
		$html = ($this->ReceiptFile()->exists()) ? $this->ReceiptFile()->forTemplate() : '(keine)';
		return DBField::create_field('HTMLText',$html);
	}

	public function generatePDF(){
		$config = $this->getSiteConfig();
		$pdf = new Fpdi();
      	$src = dirname(__FILE__).'/../../..'.$config->BillFile()->getURL();
      	$output = dirname(__FILE__).'/../../../assets/Uploads/tmp/rechnung_'.$this->ID.'.pdf';

      	
      	$pdf->Addfont('Lato','','lato.php');
      	$pageCount = $pdf->setSourceFile($src);
      	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
      		$pdf->SetPrintHeader(false);
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Lato','',8);

            $pdf->setXY(8,80);
            $pdf->WriteHtml($this->renderWith('ShopOrderTable'));
		}	

		$pdf->Output($output,'F');
		


		$tmpFolder = "Uploads/Rechnungen/".$this->ID;
		$folder = Folder::find_or_make($tmpFolder);
		$file = ($this->BillFile()->exists()) ? $this->BillFile() : File::create();
		$file->ParentID = $folder->ID;
		$file->setFromLocalFile($output, 'Uploads/Rechnungen/'.$this->ID.'/Rechnung.pdf');
		$file->write();
		$file->publishSingle();

		$this->BillFileID = $file->ID;
		$this->write();
	}

	public function generateQuittungPDF(){
			$config = $this->getSiteConfig();
			$pdf = new Fpdi();
	      	$src = dirname(__FILE__).'/../../..'.$config->ReceiptFile()->getURL();
	      	$output = dirname(__FILE__).'/../../../assets/Uploads/tmp/quittung_'.$this->ID.'.pdf';

	      	// $pdf->Addfont('Stone sans ITC','','stonesansitc.php');
	      	$pdf->Addfont('Lato','','lato.php');
	      	$pageCount = $pdf->setSourceFile($src);
	      	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
	      		$pdf->SetPrintHeader(false);
	            $pdf->AddPage();
	            $templateId = $pdf->importPage($pageNo);
	            $size = $pdf->getTemplateSize($templateId);
	            $pdf->useTemplate($templateId);
	            $pdf->SetFont('Lato','',10);
	            $pdf->setXY(100,80);
	            $pdf->WriteHtml($this->renderWith('ReceiptTable'));
	            $pdf->SetFont('Lato','',10);
	            $pdf->setXY(30,86.5);
	            $pdf->Write(0,$this->Nummer);
	           
	            $pdf->WriteHtmlCell(100,30,30,105.5,$this->Customer()->printAddress(false));
	            $pdf->WriteHtmlCell(100,30,30,126.5,"Paket ".$this->Product()->Title);
	            $pdf->setXY(10,145);
	            $pdf->WriteHtml($this->getSiteConfig()->Code.' - '.$this->getSiteConfig()->City.' / '.DBField::create_field('Date',$this->Created)->format('dd.MM.Y'));
			}	

			$pdf->Output($output,'F');
			


			$tmpFolder = "Uploads/Quittungen/".$this->ID;
			$folder = Folder::find_or_make($tmpFolder);
			$file = ($this->ReceiptFile()->exists()) ? $this->ReceiptFile() : File::create();
			$file->ParentID = $folder->ID;
			$file->setFromLocalFile($output, 'Uploads/Quittungen/'.$this->ID.'/Quittung.pdf');
			$file->write();
			$file->publishSingle();

			$this->ReceiptFileID = $file->ID;
			$this->write();
	}


	public function sendEmail(){
	   
	    $config = $this->getSiteConfig();
	    $body = $config->BillEmailBody;

	    $email = new ShopOrderEmail($config,$this,$config->Email,$this->Email,$config->BillEmailSubject,$body);
	    $email->setBCC($config->Email);

	    //Attchments
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$this->BillFile()->getURL(),'Rechnung.pdf');
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBFile()->getURL(),'AGB.pdf');

	    $email->send();

	}


	public function sendConfirmationEmail(){
	   
	    $config = $this->getSiteConfig();
	    $body = $config->PaymentEmailBody;

	    $email = new ShopOrderEmail($config,$this,$config->Email,$this->Email,$config->PaymentEmailSubject,  $body);
	    $email->setBCC($config->Email);

	    //Attachments : TO DO : Lageplan mit data
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$this->ReceiptFile()->getURL(),'Quittung.pdf');

	    $email->send();

	}


	public function deactivate(){
		$this->isActive = false;
		$this->RemainingOffers = 0;
		if ($missions = $this->Customer()->Missions()->filter('isActive',1)){
			foreach ($missions as $m) {
				$m->isActive = false;
				$m->write();
			}
		}
		$this->write();
	}
}




