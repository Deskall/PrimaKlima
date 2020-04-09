<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use setasign\Fpdi\Tcpdf\Fpdi;
use SilverStripe\Assets\Folder;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Control\Director;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DateField;
use SilverStripe\ORM\Filters\PartialMatchFilter;
use SilverStripe\ORM\Filters\ExactMatchFilter;

class EventOrder extends DataObject{

	private static $singular_name = "Rechnung";

	private static $plural_name = "Rechnungen";

	private static $db = array(
		'Nummer' => 'Varchar(255)',
		'isPaid' => 'Boolean',
		'PaymentType' => 'Varchar',
		'Price' => 'Currency',
		'DiscountPrice' => 'Currency',
		'TotalPrice' => 'Currency',
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
		'OrderID' => 'Varchar'
	);

	private static $has_one = array(
		'Participant' => Participant::class,
		'Date'   => EventDate::class,
		'BillFile'  => File::class,
		'ReceiptFile' => File::class,
		'Voucher' => EventCoupon::class,
	);

	private static $summary_fields = array(
		'Nummer' => 'Rechnungsnummer',
		'Participant.printAddress' => 'Teilnehmer',
		'PaidStatus' => 'Bezahlt',
		'PaymentResource' => 'Zahlungsmethod',
		'Created.Nice' => 'Bestelldatum',
		'Documents' => 'Dokumente'
	);

	private static $searchable_fields = [
		'Nummer' =>  array(
           "field" => TextField::class,
           "filter" => PartialMatchFilter::class,
           "title" => 'Rechnungsnummer'
        ),
		'Participant.Name' => array(
           "field" => TextField::class,
           "filter" => PartialMatchFilter::class,
           "title" => 'Teilnehmer Name'
        ),
		'Participant.Email' => array(
           "field" => TextField::class,
           "filter" => PartialMatchFilter::class,
           "title" => 'Teilnehmer E-Mail'
        ),
		'Created' => array(
           "field" => DateField::class,
           "filter" => ExactMatchFilter::class,
           "title" => 'Anmeldungsdatum'
        )
	];

	private static $default_sort = "Created DESC";

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if (!$this->Nummer){
			$this->generateNummer();
		}
		$this->writeTotalPrice();
	}

	public function writeTotalPrice(){
		$price = $this->Price;
		
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

	public function MwSt(){
		$mwst = $this->TotalPrice * floatval($this->SiteConfig()->MwSt) / 100;
		return DBCurrency::create()->setValue($mwst);
	}

	public function generateNummer(){
		$Config = $this->getEventConfig();
		$last = EventOrder::get()->sort('ID','Desc')->first();
		$increment = ($last) ? ($last->ID + 1) : 1;
		$this->Nummer = number_format ( $Config->OrderNumberOffset + $increment , 0 ,  "." ,  "." );
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('OrderID');
		$fields->removeByName('VoucherID');

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
		$this->Date()->Participants()->add($this->Participant(),['paid' => true]);
		$this->sendConfirmationEmail();
	}

	public function getPaymentResource(){
		switch ($this->PaymentType){
			case "cash":
				$type = "Bargeld";
			break;
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

	public function getEventConfig(){
		return EventConfig::get()->first();
	}

	public function getSiteConfig(){
		return SiteConfig::current_site_config();
	}

	public function getDocuments(){
		return ($this->PaymentType == "bill") ? $this->getBill() : $this->getReceipt();
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
		$config = $this->getEventConfig();
		$pdf = new Fpdi();
      	$src = Director::baseFolder().$config->BillFile()->getURL();
      	$output = Director::baseFolder().'/assets/Uploads/kurse/tmp/rechnung_'.$this->ID.'.pdf';

      
      	$pageCount = $pdf->setSourceFile($src);
      	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
      		$pdf->SetPrintHeader(false);
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
           
            $pdf->setXY(8,50);
            $pdf->WriteHtml($this->renderWith('OrderTable'));
		}	

		$pdf->Output($output,'F');
		


		$tmpFolder = "Uploads/kurse/Rechnungen/".$this->ID;
		$folder = Folder::find_or_make($tmpFolder);
		$file = ($this->BillFile()->exists()) ? $this->BillFile() : File::create();
		$file->ParentID = $folder->ID;
		$file->setFromLocalFile($output, 'Uploads/kurse/Rechnungen/'.$this->ID.'/Rechnung.pdf');
		$file->write();
		$file->publishSingle();

		$this->BillFileID = $file->ID;
		$this->write();
	}

	public function generateQuittungPDF(){
			$config = $this->getEventConfig();
			$pdf = new Fpdi();
	      	$src = Director::baseFolder().$config->ReceiptFile()->getURL();
	      	$output = Director::baseFolder().'/assets/Uploads/kurse/tmp/quittung_'.$this->ID.'.pdf';

	      
	      	$pageCount = $pdf->setSourceFile($src);
	      	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
	      		$pdf->SetPrintHeader(false);
	            $pdf->AddPage();
	            $templateId = $pdf->importPage($pageNo);
	            $size = $pdf->getTemplateSize($templateId);
	            $pdf->useTemplate($templateId);
	           
	            $pdf->setXY(100,80);
	            $pdf->WriteHtml($this->renderWith('ReceiptTable'));
	           
	            $pdf->setXY(30,86.5);
	            $pdf->Write(0,$this->Nummer);
	           
	            $pdf->WriteHtmlCell(100,30,30,105.5,$this->Participant()->Vorname.' '.$this->Participant()->Name);
	            $pdf->WriteHtmlCell(100,30,30,126.5,$this->Date()->Event()->Title);
	            $pdf->setXY(10,145);
	            $pdf->WriteHtml($this->getSiteConfig()->Code.' - '.$this->getSiteConfig()->City.' / '.DBField::create_field('Date',$this->Created)->format('dd.MM.Y'));
			}	

			$pdf->Output($output,'F');
			


			$tmpFolder = "Uploads/kurse/Quittungen/".$this->ID;
			$folder = Folder::find_or_make($tmpFolder);
			$file = ($this->ReceiptFile()->exists()) ? $this->ReceiptFile() : File::create();
			$file->ParentID = $folder->ID;
			$file->setFromLocalFile($output, 'Uploads/kurse/Quittungen/'.$this->ID.'/Quittung.pdf');
			$file->write();
			$file->publishSingle();

			$this->ReceiptFileID = $file->ID;
			$this->write();
	}

	public function sendEmail(){
	   
	    $siteconfig = SiteConfig::current_site_config();
	    $config = $this->getEventConfig();
	    $body = $config->BillEmailBody;

	    $email = new OrderEmail($config,$this,$siteconfig->Email,$this->Email,$config->BillEmailSubject,  $body);
	    $email->setBCC($siteconfig->Email);

	    //Attchments
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$this->BillFile()->getURL(),'Rechnung.pdf');
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBFile()->getURL(),'AGB.pdf');

	    $email->send();

	}

	public function sendConfirmationEmail(){
	   
	    $siteconfig = SiteConfig::current_site_config();
	    $config = $this->getEventConfig();
	    $body = $config->PaymentEmailBody;

	    $email = new OrderEmail($config,$this,$siteconfig->Email,$this->Email,$config->PaymentEmailSubject,  $body);
	    $email->setBCC($siteconfig->Email);

	    //Attachments : TO DO : Lageplan mit data
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$this->ReceiptFile()->getURL(),'Quittung.pdf');

	    $email->send();

	}
}




