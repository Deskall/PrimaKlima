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
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBCurrency;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ShopOrder extends DataObject{

	private static $singular_name = "Rechnung";

	private static $plural_name = "Rechnungen";

	private static $db = array(
		'Nummer' => 'Varchar(255)',
		'isPaid' => 'Boolean',
		'PaymentType' => 'Varchar',
		'IP' => 'Varchar',
		'TotalPrice' => 'Currency',
		'DiscountPrice' => 'Currency',
		'TransportPrice' => 'Currency',
		'FullTotalPrice' => 'Currency',
		'PaymentMethod' => 'Varchar',
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
		'Additional' => 'Text', 
		'AGB' => 'Boolean(0)',
		'PayPalOrderID' => 'Varchar'
	);

	private static $has_one = array(
		'Customer' => ShopCustomer::class,
		'BillFile'  => File::class,
		'ReceiptFile' => File::class,
		'Voucher' => Coupon::class
	);

	private static $has_many = [
		'Items' => OrderItem::class
	];

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
		'Customer.Name' => array(
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
		if (in_array($this->PaymentType,[ "bill", "cash" ]) && !$this->isPaid){
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

	
	public function getPaymentResource(){
		switch ($this->PaymentType){
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

    public function printDeliveryAddress(){
        $html = '<p>';
        if ($this->DeliveryCompany){
            $html .= $this->DeliveryCompany.'<br/>';
        }
        $html .= $this->DeliveryGender.' '.$this->DeliveryFirstName.' '.$this->DeliveryName.'<br/>';
        $html .= $this->DeliveryStreet.'<br/>';
        if ($this->DeliveryAddress){
            $html .= $this->DeliveryAddress.'<br/>';
        }
        $html .= $this->DeliveryPostalCode.' - '.$this->DeliveryCity.'<br/>';
        if ($this->DeliveryCountry){
            $html .= i18n::getData()->getCountries()[strtolower($this->DeliveryCountry)];
        }
        $html .= '</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }


	public function getPaidStatus(){
		$paid = ($this->isPaid) ? "Ja" : "Nein";
	    return DBField::create_field('Varchar', $paid);
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

	public function MwSt(){
		$mwst = $this->TotalPrice * floatval($this->getSiteConfig()->MwSt) / 100;
		$mwst = number_format($mwst,2);
		return DBCurrency::create()->setValue($mwst);
	}

	// public function getOrderPrice(){
	//     setlocale(LC_MONETARY, 'de_DE');
	//     return DBField::create_field('Varchar',money_format('%i',$this->FullTotalPrice));
	// }

	// public function getOrderSubPrice(){
	//     setlocale(LC_MONETARY, 'de_DE');
	//     $price = $this->Price;
	//     return DBField::create_field('Varchar',money_format('%i',$price));
	// }


	// public function getOrderPriceNetto(){
	//     $price = $this->Price * 100 / 107.7;
	   
	//     setlocale(LC_MONETARY, 'de_DE');
	//     return DBField::create_field('Varchar',money_format('%i',$price));
	// }

	// public function getOrderMwSt(){
	//     // $price = $this->Price - ($this->Price * 100 / 107.7);
	//     $price = 0;
	//     setlocale(LC_MONETARY, 'de_DE');
	//     return DBField::create_field('Varchar',money_format('%i',$price));
	// }

	public function getReceipt(){
		// $this->generateQuittungPDF();
		$html = ($this->ReceiptFile()->exists()) ? $this->ReceiptFile()->forTemplate() : '(keine)';
		return DBField::create_field('HTMLText',$html);
	}

	public function generatePDF(){
		$config = $this->getSiteConfig();
		$pdf = new Fpdi();
      	$src = Director::baseFolder().$config->BillFile()->getURL();
      	$output = Director::baseFolder().'/assets/Uploads/Webshop/tmp/rechnung_'.$this->ID.'.pdf';

      	
      	// replace with project font $pdf->Addfont('Lato','','lato.php');
      	$pageCount = $pdf->setSourceFile($src);
      	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
      		$pdf->SetPrintHeader(false);
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            // $pdf->SetFont('Lato','',8);

            $pdf->setXY(8,50);
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

	// public function generateQuittungPDF(){
	// 		$config = $this->getSiteConfig();
	// 		$pdf = new Fpdi();
	//       	$src = dirname(__FILE__).'/../../..'.$config->ReceiptFile()->getURL();
	//       	$output = dirname(__FILE__).'/../../../assets/Uploads/tmp/quittung_'.$this->ID.'.pdf';

	//       	// $pdf->Addfont('Stone sans ITC','','stonesansitc.php');
	//       	// $pdf->Addfont('Lato','','lato.php');
	//       	$pageCount = $pdf->setSourceFile($src);
	//       	for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
	//       		$pdf->SetPrintHeader(false);
	//             $pdf->AddPage();
	//             $templateId = $pdf->importPage($pageNo);
	//             $size = $pdf->getTemplateSize($templateId);
	//             $pdf->useTemplate($templateId);
	//             // $pdf->SetFont('Lato','',10);
	//             $pdf->setXY(100,80);
	//             $pdf->WriteHtml($this->renderWith('ReceiptTable'));
	//             // $pdf->SetFont('Lato','',10);
	//             $pdf->setXY(30,86.5);
	//             $pdf->Write(0,$this->Nummer);
	           
	//             $pdf->WriteHtmlCell(100,30,30,105.5,$this->Customer()->printAddress(false));
	//             $pdf->WriteHtmlCell(100,30,30,126.5,"Paket ".$this->Product()->Title);
	//             $pdf->setXY(10,145);
	//             $pdf->WriteHtml($this->getSiteConfig()->Code.' - '.$this->getSiteConfig()->City.' / '.DBField::create_field('Date',$this->Created)->format('dd.MM.Y'));
	// 		}	

	// 		$pdf->Output($output,'F');
			


	// 		$tmpFolder = "Uploads/Quittungen/".$this->ID;
	// 		$folder = Folder::find_or_make($tmpFolder);
	// 		$file = ($this->ReceiptFile()->exists()) ? $this->ReceiptFile() : File::create();
	// 		$file->ParentID = $folder->ID;
	// 		$file->setFromLocalFile($output, 'Uploads/Quittungen/'.$this->ID.'/Quittung.pdf');
	// 		$file->write();
	// 		$file->publishSingle();

	// 		$this->ReceiptFileID = $file->ID;
	// 		$this->write();
	// }


	public function sendEmail(){
	   
	    $config = $this->getSiteConfig();
	    $body = $config->BillEmailBody;

	    $email = new ShopOrderEmail($config,$this,$config->Email,$this->Email,$config->BillEmailSubject,$body);
	    $email->setBCC($config->Email);
	    $email->setBCC('guillaume.pacilly@deskall.ch');

	    //Attchments
	    if ($this->PaymentType == "bill"){
	    	$email->addAttachment(dirname(__FILE__).'/../../..'.$this->BillFile()->getURL(),'Rechnung.pdf');
	    }
	    
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBFile()->getURL(),'AGB.pdf');

	    $email->send();

	}


	public function sendConfirmationEmail(){
	   
	    $config = $this->getSiteConfig();
	    $body = $config->PaymentEmailBody;

	    $email = new ShopOrderEmail($config,$this,$config->Email,$this->Email,$config->PaymentEmailSubject,  $body);
	    $email->setBCC($config->Email);
	     $email->setBCC('guillaume.pacilly@deskall.ch');

	    //Attachments : TO DO : Lageplan mit data
	    $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBFile()->getURL(),'AGB.pdf');

	    $email->send();

	}
}




