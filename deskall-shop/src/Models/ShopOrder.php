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
		'Gender'  => 'Varchar',
		'Address'  => 'Varchar',
		'PostalCode'  => 'Varchar',
		'City'  => 'Varchar',
		'Country'  => 'Varchar',
		'Phone'  => 'Varchar',
		'UIDNumber' => 'Varchar',
		'OrderID' => 'Varchar',
		'Quantity' => 'Int',
		'wasSeen' => 'Boolean(0)',
		'AGB' => 'Boolean(0)'
	);

	private static $has_one = array(
		'Customer' => ShopCustomer::class,
		'BillFile'  => File::class,
		'ReceiptFile' => File::class,
		'Voucher' => Coupon::class,
		'Product' => Package::class
	);

	private static $summary_fields = array(
		'Nummer' => 'Rechnungsnummer',
		'Customer.printAddress' => 'Kunde',
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
		'Customer.Member.Surname' => array(
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
	}

	public function generateNummer(){
		$Config = $this->getSiteConfig();
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

	public function canMarkAsPaid(){
		if ($this->PaymentType == "bill" && !$this->isPaid){
			return true;
		}
		return false;
	}
	
	public function MarkAsPaid(){
		$this->isPaid = true;
		$this->generateQuittungPDF();
		$this->write();
		$this->sendConfirmationEmail();
	}

	public function OnlineDeliveryLink(){
	    return 'shop/online-lieferung/'.$this->ID.'/';
	}

	public function generateCertificatLink(){
	    return 'shop/zertifikat/'.$this->ID.'/';
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

	public function getSiteConfig(){
		return SiteConfig::current_site_config();
	}

	public function getDocuments(){
		return ($this->isPaid) ? $this->getReceipt() : $this->getBill();
	}

	public function getBill(){
		//$this->generatePDF();
		$html = ($this->BillFile()->exists()) ? $this->BillFile()->forTemplate() : '(keine)';
		return DBField::create_field('HTMLText',$html);
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

	public function getReceipt(){
		//$this->generateQuittungPDF();
		$html = ($this->ReceiptFile()->exists()) ? $this->ReceiptFile()->forTemplate() : '(keine)';
		return DBField::create_field('HTMLText',$html);
	}

	public function generatePDF(){
		$config = $this->getProductConfig();
		$pdf = new Fpdi();
      	$src = dirname(__FILE__).'/../../..'.$config->BillFile()->getURL();
      	$output = dirname(__FILE__).'/../../../assets/Uploads/tmp/rechnung_'.$this->ID.'.pdf';

      	$pdf->Addfont('Stone sans ITC','','stonesansitc.php');
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
			$config = $this->getProductConfig();
			$pdf = new Fpdi();
	      	$src = dirname(__FILE__).'/../../..'.$config->ReceiptFile()->getURL();
	      	$output = dirname(__FILE__).'/../../../assets/Uploads/tmp/quittung_'.$this->ID.'.pdf';

	      	$pdf->Addfont('Stone sans ITC','','stonesansitc.php');
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
	           
	            $pdf->WriteHtmlCell(100,30,30,105.5,$this->Customer()->Member()->FirstName.' '.$this->Customer()->Member()->Surname);
	            $pdf->WriteHtmlCell(100,30,30,126.5,$this->Quantity." * ".$this->Product()->Title);
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

	public function generateCertificat(){
		$config = $this->getProductConfig();
		$pdf = new Fpdi();
      	$src = dirname(__FILE__).'/../../..'.$config->CertificatFile()->getURL();
      	$output = dirname(__FILE__).'/../../../assets/Uploads/tmp/zertifikat_'.$this->ID.'.pdf';

      	$pdf->Addfont('Stone sans ITC','','stonesansitc.php');
      	$pdf->Addfont('lato','','lato.php');
      	$pdf->Addfont('latob','','latob.php');
      	$pageCount = $pdf->setSourceFile($src);
      	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
      		$pdf->SetPrintHeader(false);
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Lato','',8);

            $pdf->setXY(8,40);
            $pdf->WriteHtml($config->parseString($config->CertificatHTML,$this));
		}	

		$pdf->Output($output,'F');
		


		$tmpFolder = "Uploads/Zertifikate/".$this->ID;
		$folder = Folder::find_or_make($tmpFolder);
		$file = ($this->CertificatFile()->exists()) ? $this->CertificatFile() : File::create();
		$file->ParentID = $folder->ID;
		$file->setFromLocalFile($output, 'Uploads/Zertifikate/'.$this->ID.'/Zertifikat.pdf');
		$file->write();
		$file->publishSingle();

		$this->CertificatFileID = $file->ID;
		$this->write();
	}

	public function sendEmail(){
	   
	    $siteconfig = SiteConfig::current_site_config();
	    $config = $this->getProductConfig();
	    $body = $config->BillEmailBody;

	    $email = new ShopOrderEmail($config,$this,$siteconfig->Email,$this->Email,$config->BillEmailSubject,  $body);
	    $email->setBCC($siteconfig->Email);

	    //Attchments
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$this->BillFile()->getURL(),'Rechnung.pdf');
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBFile()->getURL(),'AGB.pdf');

	    $email->send();

	}

	public function sendConfirmationEmail(){
	   
	    $siteconfig = SiteConfig::current_site_config();
	    $config = $this->getProductConfig();
	    $body = $config->PaymentEmailBody;

	    $email = new ShopOrderEmail($config,$this,$siteconfig->Email,$this->Email,$config->PaymentEmailSubject,  $body);
	    $email->setBCC($siteconfig->Email);

	    //Attachments : TO DO : Lageplan mit data
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$this->ReceiptFile()->getURL(),'Quittung.pdf');

	    $email->send();

	}
}




