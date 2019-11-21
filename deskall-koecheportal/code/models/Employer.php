<?php
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\DropDownField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\DateField;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class Employer extends Member {

	private static $db = array(
		'Company' => 'Varchar(255)',
		'AddressStreet' => 'Varchar(255)',
		'AddressPostalCode' => 'Varchar(255)',
		'AddressPlace' => 'Varchar(255)',
		'AddressCountry' => 'Varchar(255)',
		'Telephone' => 'Varchar(255)',

		'Homepage' => 'Varchar(255)',
		'SocialFacebook' => 'Varchar(255)',
		'SocialTwitter' => 'Varchar(255)',
		'SocialInstagram' => 'Varchar(255)',
		'SocialPinterest' => 'Varchar(255)',

		'ContactPersonTelephone' => 'Varchar(255)',
		'ContactPersonMobile' => 'Varchar(255)',
		'ContactPersonEmail' => 'Varchar(255)',

		'BillingAddressIsCompanyAddress' => 'Boolean',
		'BillingAddressCompany' => 'Varchar(255)',
		'BillingAddressStreet' => 'Varchar(255)',
		'BillingAddressPostalCode' => 'Varchar(255)',
		'BillingAddressPlace' => 'Varchar(255)',
		'BillingAddressCountry' => 'Varchar(255)',		
		'Cipher' => 'Varchar(255)',	
		'ReasonWhy' => 'HTMLText',	
		'FlatrateEndDate' => 'Date',
		'ActiveUser'		=> 'Boolean',
	);

	private static $has_many = array(
		'Credits' => 'EmployerAdvertisementCredit',
		'PackageOrders' => 'PackageOrder',
		'EmployerAdvertisements' => 'EmployerAdvertisement'
	);

	private static $many_many = array(
		'Offers' => 'EmloyerConfigItem',
		'Infrastructure' => 'EmloyerConfigItem',
	);


	private static $has_one = array(
		'ConfigurationSet' => 'EmployerConfig',
		'Picture' => Image::class,
	);

	private static $summary_fields = array(
		'generateClientNumber' => 'Kundennummer',
		'Company' => 'Firma',
		'AddressPlace' => 'Ort',
	);


	private static $defaults = array(
		'ConfigurationSetID' => 1,
		'BillingAddressIsCompanyAddress' => 1
	);

	private static $singular_name = 'Arbeitgeber';

	private static $plural_name = 'Arbeitgeber';


	public function generateClientNumber(){
		$SiteConfig = SiteConfig::current_site_config();
		return number_format ( $this->ID + $SiteConfig->ClientNumberOffset , 0 ,  "." ,  "." );
	}	





	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(new TabSet('Root'));

		$fields->addFieldToTab('Root.Kontakt', CheckboxField::create('EmailConfirmed', _t('ARBEITGEBER.EmailConfirmed', 'Bestätigen')) );	


		$fields->addFieldToTab('Root.Kontakt', HeaderField::create('AdressTitle', _t('ARBEITGEBER.AdressTitle', 'Firmenadresse'), 3) );	
		$fields->addFieldToTab('Root.Kontakt', TextField::create('Company', _t('ARBEITGEBER.Company', 'Firma')) );
		$fields->addFieldToTab('Root.Kontakt', TextField::create('AddressStreet', _t('ARBEITGEBER.AddressStreet', 'Adresse')));
		$fields->addFieldToTab('Root.Kontakt', TextField::create('AddressPostalCode', _t('ARBEITGEBER.AddressPostalCode', 'PLZ')));
		$fields->addFieldToTab('Root.Kontakt', TextField::create('AddressPlace', _t('ARBEITGEBER.AddressPlace', 'Ort')));
		$fields->addFieldToTab('Root.Kontakt', CountryDropdownField::create('AddressCountry', _t('ARBEITGEBER.AddressCountry', 'Land')));
		$fields->addFieldToTab('Root.Kontakt', TextField::create('Email', _t('ARBEITGEBER.Email', 'E-Mail')) );
		$fields->addFieldToTab('Root.Kontakt', TextField::create('Telephone', _t('ARBEITGEBER.Telephone', 'Telefon')));
		$fields->addFieldToTab('Root.Kontakt', TextField::create('Cipher', _t('ARBEITGEBER.Cipher', 'Chiffre')));



		$fields->addFieldToTab('Root.Kontakt', HeaderField::create('BillingAdressTitle', _t('ARBEITGEBER.BillingAdressTitle', 'Rechnungsadresse'), 3) );	

		$fields->addFieldToTab('Root.Kontakt', CheckboxField::create('BillingAddressIsCompanyAddress', _t('ARBEITGEBER.BillingAddressIsCompanyAddress', 'Rechnungsadresse ist Firmenadresse')));

		$fields->addFieldToTab("Root.Kontakt", Wrapper::create(
				TextField::create('BillingAddressCompany', _t('ARBEITGEBER.BillingAddressCompany', 'Firma')),
				TextField::create('BillingAddressStreet', _t('ARBEITGEBER.BillingAddressStreet', 'Adresse')),
				TextField::create('BillingAddressPostalCode', _t('ARBEITGEBER.BillingAddressPostalCode', 'PLZ')),
				TextField::create('BillingAddressPlace', _t('ARBEITGEBER.BillingAddressPlace', 'Ort')),
				CountryDropdownField::create('BillingAddressCountry', _t('ARBEITGEBER.BillingAddressCountry', 'Land'))
			)
			->hideIf("BillingAddressIsCompanyAddress")->isChecked()->end()
		);


		$fields->addFieldToTab('Root.Kontakt', HeaderField::create('ContactPersonTitle', _t('ARBEITGEBER.ContactPersonTitle', 'Ansprechparter'), 3) );

		$fields->addFieldToTab('Root.Kontakt', TextField::create('FirstName', _t('ARBEITGEBER.FirstName', 'Vorname')) );
		$fields->addFieldToTab('Root.Kontakt', TextField::create('Surname', _t('ARBEITGEBER.SurName', 'Nachname')) );
		$fields->addFieldToTab('Root.Kontakt', TextField::create('ContactPersonTelephone', _t('ARBEITGEBER.ContactPersonTelephone', 'Telefon')) );
		$fields->addFieldToTab('Root.Kontakt', TextField::create('ContactPersonMobile', _t('ARBEITGEBER.ContactPersonMobile', 'Mobil')) );
		$fields->addFieldToTab('Root.Kontakt', TextField::create('ContactPersonEmail', _t('ARBEITGEBER.ContactPersonEmail', 'E-Mail')) );


		$fields->addFieldToTab('Root.Firmenporträt', UploadField::create('Picture', _t('ARBEITGEBER.Picture', 'Logo'))->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif') ));
		
		$fields->addFieldToTab('Root.Firmenporträt', HeaderField::create('TitleSocial', _t('ARBEITGEBER.TitleSocial', 'Online Kanäle'), 3) );
		$fields->addFieldToTab('Root.Firmenporträt', TextField::create('Homepage', _t('ARBEITGEBER.Homepage', 'Homepage')) );
		$fields->addFieldToTab('Root.Firmenporträt', TextField::create('SocialFacebook', _t('ARBEITGEBER.SocialFacebook', 'Facebook')) );
		$fields->addFieldToTab('Root.Firmenporträt', TextField::create('SocialTwitter', _t('ARBEITGEBER.SocialTwitter', 'Twitter')) );
		$fields->addFieldToTab('Root.Firmenporträt', TextField::create('SocialInstagram', _t('ARBEITGEBER.SocialInstagram', 'Instagram')) );
		$fields->addFieldToTab('Root.Firmenporträt', TextField::create('SocialPinterest', _t('ARBEITGEBER.SocialPinterest', 'Pinterest')) );




		$fields->addFieldToTab('Root.Firmenporträt', HeaderField::create('TitleOffers', _t('ARBEITGEBER.TitleOffers', 'Angebot'), 3) );

		$fields->addFieldToTab('Root.Firmenporträt', ListboxField::create('Offers', _t('ARBEITGEBER.Offers', 'Was bieten wir?'), $this->ConfigurationSet()->Offers()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte Wählen')) );
		$fields->addFieldToTab('Root.Firmenporträt', ListboxField::create('Infrastructure', _t('ARBEITGEBER.Infrastructure', 'Infrastruktur'), $this->ConfigurationSet()->Infrastructure()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte Wählen')) );
		$fields->addFieldToTab('Root.Firmenporträt', HTMLEditorField::create('ReasonWhy', _t('ARBEITGEBER.ReasonWhy', 'Warum sollst du bei uns arbeiten?')) );




		$EmployerAdvertisementFieldGridFieldConfig = GridFieldConfig_RelationEditor::create();
//		$EmployerAdvertisementFieldGridFieldConfig->addComponent(new GridFieldTitleHeader());
		$EmployerAdvertisementFieldGridFieldConfig->getComponentByType(GridFieldAddExistingAutocompleter::class);
		$EmployerAdvertisementFieldGridFieldConfig->getComponentByType(GridFieldDeleteAction::class);
		$EmployerAdvertisementField = new GridField(
			'EmployerAdvertisements',
			_t('KOCH.EmployerAdvertisement', 'Inserate'),
			$this->EmployerAdvertisements(),
			$EmployerAdvertisementFieldGridFieldConfig
		);

		$fields->addFieldToTab('Root.Inserate', $EmployerAdvertisementField );

		$EmployerAdvertisementField = new GridField(
			'Credits',
			_t('KOCH.Credits', 'Credits'),
			$this->Credits()
		);


		$fields->addFieldToTab('Root.Credits', $EmployerAdvertisementField );

		return $fields;
	}


	public function getTitle(){
		$str = $this->Company;
		if( $this->AddressPlace ){
			$str .= ', '.$this->AddressPlace;
		}
		return $str;
	}


	public function AdsAvailable(){
		return sizeof( $this->Credits() ) > 0 || strtotime( $this->FlatrateEndDate ) > time();
	}

	public function GetAdDuration(){
		return $this->Credits()->First()->RunTime.' '.$this->Credits()->First()->RunTimeCurrency;
	}



	public function AdAvailabilityString(){

		if( strtotime( $this->FlatrateEndDate ) > time() ){
			return 'Sie köneen bis zum '.date('d.m.Y', strtotime($this->FlatrateEndDate)).' unbegrenzt viele Inserate schalten';
		}elseif( sizeof( $this->Credits() ) > 0 ){
			return 'Sie können noch '.sizeof( $this->Credits() ).' Inserate schalten mit einer Anzeigedauer von je '.$this->Credits()->First()->RunTimeTitle.'.';
		}else{
			return 'Sie können derzeit keine Inserate freischalten. Sie können aber dennoch Inserate als Entwurf erfassen und zu einem späteren Zeitpunkt freischalten.';
		}
	}
}