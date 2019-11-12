<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropDownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;

class PackageOrder extends DataObject{
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Content' => 'HTMLText',
		'isPaid' => 'Boolean',
		'NumOfAds' => 'Int',
		'Price' => 'Currency',
		'PriceOrig' => 'Currency',
		'RunTime' => 'Int',
		'RunTimeCurrency' => 'Varchar(255)',
		'RunTimeTitle' => 'Varchar(255)',
		'isFlatrate' => 'Boolean'
	);

	private static $has_one = array(
		'Employer' => 'Employer',
		'Coupon'   => 'Coupon',
		'Package'  => 'Package'
	);

	private static $summary_fields = array(
		'generateOrderNumber' => 'Rechnungsnummer',
		'Employer.Company' => 'Empfänger',
		'isPaid' => 'Bezahlt',
		'Title' => 'Titel',
		'Created.Nice' => 'Bestelldatum',
		'buttonInvoice' => 'Rechnung'
	);

	private static $default_sort = "Created DESC";

	public function generateOrderNumber(){
		$SiteConfig = SiteConfig::current_site_config();
		return number_format ( $this->ID + $SiteConfig->OrderNumberOffset , 0 ,  "." ,  "." );
	}	

//	public function buttonInvoice(){
//
//		$html = HTMLText::create();
//		$html->setValue('<a class="action action-detail edit-link" data-open-invoice href="/order/invoice/51" target="_blank" title="Rechnung"></a>');
//		return $html;
//	}



	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(new TabSet('Root'));

		$fields->addFieldToTab('Root.Main', LiteralField::create('GetInfovice', '<a href="/order/invoice/'.$this->ID.'" target="_blank" >Download Rechnung</a>') );

		$fields->addFieldToTab('Root.Main', NumericField::create('Price', 'Rechnungsbetrag') );
		$fields->addFieldToTab('Root.Main', CheckboxField::create('isPaid', 'Rechnung wurde bezahlt') );

		$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Paket-Titel') );
		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Content', 'Rechnungsinhalt') );


		return $fields;
	}








	public function confirmPayment(){
		$this->isPaid = true;

		$employer = $this->Employer();
		$employer->ID;

		if( $this->isFlatrate ){
			if(  strtotime($this->Employer()->FlatrateEndDate) < time() ){
				$this->Employer()->FlatrateEndDate = strtotime('+'.$this->RunTime.' '.$this->RunTimeCurrency);
			}else{
				$this->Employer()->FlatrateEndDate = strtotime( $this->Employer()->FlatrateEndDate. '+'.$this->RunTime.' '.$this->RunTimeCurrency);
			}

			foreach ($this->Employer()->EmployerAdvertisements()->Filter(array('isPaid' => true, 'State' => 'live')) as $ad) {
				$ad->PackageID = 3;
				$ad->write();
			}

		}else{
			for( $i = 0; $i < $this->NumOfAds; $i++  ){
				$credit = EmployerAdvertisementCredit::create();
				$credit->PackageID = $this->Package()->ID;
				$credit->EmployerID = $employer->ID;
				$credit->RunTime = $this->RunTime;
				$credit->RunTimeCurrency = $this->RunTimeCurrency;
				$credit->RunTimeTitle = $this->RunTimeTitle;
				$credit->write();
			}
		}

		$this->Employer()->write();
		$this->write();


	}
}




