<?php
use SilverStripe\Security\Security;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropDownField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\PasswordField;
use SilverStripe\Forms\OptionsetField;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\LiteralField;


    class AccountPage extends Page {

    	public function GetUserData( $fieldname ){
    		$member = Security::getCurrentUser();
    		return $member->{$fieldname};
    	}

    	public function AdsAvailable( ){
    		$member = Security::getCurrentUser();
    		return $member->AdsAvailable();
    	}

    	public function hasOpenOrder( ){
    		$member = Security::getCurrentUser();

			$orders = PackageOrder::get()->filter(array(
				'EmployerID' => $member->ID,
				'isPaid:not' => true
			));

   			return sizeof($orders->toArray()) > 0;
    	}

    	public function UserConfirmationOpen(){
    		return !Security::getCurrentUser()->EmailConfirmed;
    	}

    	public function OpenApplications(){
    		$member = Security::getCurrentUser();


			$applications = CookApplication::get()->filter(array(
				'EmployerAdvertisement.EmployerID' => $member->ID,
				'isRead:not' => true
			));

   			return $applications;
    	}


    	public function AdAvailabilityString( ){
    		$member = Security::getCurrentUser();
    		return $member->AdAvailabilityString();
    	}


    	public function isLoggedIn( $fieldname ){
    		$member = Security::getCurrentUser();
    		return $member->{$fieldname};
    	}

    	public function Applications(){
    		$member = Security::getCurrentUser();

    		if( $member->ClassName == 'Cook' ){
				return CookApplication::get()->filter(array(
					'CookID' => $member->ID
				));
    		}else{
				return CookApplication::get()->filter(array(
					'EmployerAdvertisement.EmployerID' => $member->ID
				));
    		}
    	}



		public function PackageData() {

			$Packages = Package::get();
			$featuresSRC = array();

			foreach ( PackageConfigItem::get() as $feature ) {
				$featuresSRC[ 'ftr-'.$feature->ID ] = $feature->Title__de_DE;
			}

			$data = new ArrayList([
				new ArrayData([
					'Title' 	=> '',
					'RunTime' 	=> 'Laufzeit',
					'NumOfAds'	=> 'Anzahl Stelleninserate',
					'Features'  => PackageConfigItem::get()
				]),
			]);

			foreach ($Packages as $Package ) {

				$Features = new ArrayList();

				$linked_featrues = array();
				foreach ($Package->Features() as $feature ) {
					array_push($linked_featrues, $feature->ID );
				}

				foreach ($featuresSRC as $featrueKey => $featrueVal ) {
					if( in_array(intval(substr($featrueKey, 4)), $linked_featrues ) ){
						$Features->push( new ArrayData(array(
							'Title__de_DE' => 'y'
						)));
					}else{
						$Features->push( new ArrayData(array(
							'Title__de_DE' => 'n'
						)));
					}
				}
				
				if( $Package->PackegeOptions() ){
					$PriceOptions = new ArrayList();

					foreach ( $Package->PackegeOptions() as $Option ) {
						$PriceOptions->push(new ArrayData(array(
							'Title' => $Option->Title__de_DE,
							'Price' => $Option->Price,
							'RunTime' => $Option->RunTime,
							'ID'	=> $Option->ID,
						)));
					}
				}else{
					$PriceOptions = [];
				}

				$data->push(
					new ArrayData(array(
						'Title' 	=> $Package->Title__de_DE,
						'PackageCode' 	=> strtolower( $Package->Title__de_DE ),
						'RunTime' 	=> $Package->RunTimeTitle__de_DE,	
						'NumOfAds'	=> $Package->NumOfAdsTitle__de_DE,
						'Features'  => $Features,
						'Price'		=> $Package->GetFinalPrice(),
						'PriceOptions'  => $PriceOptions,
						'ID'		=> $Package->ID
					))
				);
			}

			return $data;
		}


		public function GetUserOrders(){
			$member = Security::getCurrentUser();

			return $member->PackageOrders();
		}








    }


	class AccountPage_Controller extends PageController {

		private static $allowed_actions = array ('CookFunctionForm', 'CookPersonalDataForm', 'CookProfessionalDataForm', 'CookDocumentsForm', 'EmployerAddressForm', 'EmployerPortraitForm', 'EmployerAdvertisementsForm', 'RegistrationForm');
    	
		public function init() {
			parent::init();
			Requirements::javascript("themes/koecheportal/js/tinymce/tinymce.min.js");
			Requirements::javascript("themes/koecheportal/js/main.js");

			Requirements::block('framework/thirdparty/jquery/jquery.js');


		}


		public function CookFunctionForm(){

			$Cook = Member::get()->byID(Security::getCurrentUser()->ID);

			$fields = new FieldList(
				CheckboxField::create('isRental', _t('KOCH.ImRental', 'Ich bin als Mietkoch verfügbar')),
				CheckboxField::create('isCandidate', _t('KOCH.ImCandidate', 'Ich bin als Bewerber verfügbar'))
			);

			$actions = new FieldList(
				FormAction::create('StoreCookData','save')->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom( $Cook );

			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');

			return $form;
		}

		public function CookPersonalDataForm() {
			$Cook = Member::get()->byID(Security::getCurrentUser()->ID);
			$fields = new FieldList(
				LiteralField::create('colLeftOpen', '<div class="col-left">'),
//				FrontendUploadField::create('Picture', _t('KOCH.Picture', 'Porträt'))->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif') )->setCanPreviewFolder(false)->setPreviewMaxWidth(100)->setPreviewMaxHeight(100)->setOverwriteWarning(false),

				UploadField::create('Picture', _t('KOCH.Picture', 'Porträt'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setPermissions(array(
						'delete' => false,
						'detach' => true)),



				LiteralField::create('colLeftClose', '</div>'),
				LiteralField::create('colRight', '<div class="col-right">'),
				TextField::create('FirstName', _t('KOCH.FirstName', 'Vorname')) ,
				TextField::create('Surname', _t('KOCH.SurName', 'Nachname')) ,
				TextField::create('MaritalStatus', _t('KOCH.MaritalStatus', 'Familienstand ')) ,
				LiteralField::create('colRightClose', '</div>'),
				LiteralField::create('colFull', '<div class="col-full">'),
				HeaderField::create('ContactTitle', _t('KOCH.ContactTitle', 'Kontaktangaben'), 3) ,
				TextField::create('Address', _t('KOCH.Address', 'Adresse')) ,
				TextField::create('PostalCode', _t('KOCH.PostalCode', 'PLZ')) ,
				TextField::create('Place', _t('KOCH.Place', 'Ort')) ,
				CountryDropdownField::create('Country', _t('KOCH.Country', 'Land'))->setAttribute("data-chosen", 'true') ,
				TextField::create('Email', _t('KOCH.Email', 'E-Mail')) ,
				TextField::create('Mobile', _t('KOCH.Mobile', 'Mobile')),
				LiteralField::create('colFullClose', '</div>')
			);

			$actions = new FieldList(
				FormAction::create('StoreCookData',_t('KOCH.Save', 'Änderungen speichern'))->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom( $Cook );
			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');
			return $form;
		}


		public function CookProfessionalDataForm() {

			$Cook = Member::get()->byID(Security::getCurrentUser()->ID);

			$CVField = new GridField(
				'CVItmes',
				_t('KOCH.ProfessionalExperiences', 'Berufliche Erfahrungen'),
				$Cook->CVItmes(),
				GridFieldConfig::create()
					->addComponent(new GridFieldButtonRow('before'))
					->addComponent(new GridFieldTitleHeader())
					->addComponent(new GridFieldEditableColumns())
					->addComponent(new GridFieldDeleteAction())
					->addComponent(new GridFieldAddNewInlineButton())
					->addComponent(new GridFieldOrderableRows('SortOrder'))
			);
			DateField::set_default_config('showcalendar', true);
			$CVField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
				'StartDate' => array(
					'title' => _t('KOCH.StartDate', 'Von'),
					'callback' => function ($record, $column, $holiDayGridfield){
						return DateField::create('StartDate', _t('KOCH.StartDate', 'Von'))->setConfig('showcalendar', true)->setConfig('dateformat', 'yyyy/MM')->setAttribute('placeholder', 'YYYY/MM');
					}
				),
				'EndDate' => array(
					'title' => _t('KOCH.EndDate', 'Bis'),
					'callback' => function ($record, $column, $holiDayGridfield){
						return DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('showcalendar', true)->setConfig('dateformat', 'yyyy/MM')->setAttribute('placeholder', 'YYYY/MM');
					}
				),
				'Description' => array (
					'title' => _t('KOCH.Description', 'Job-Beschreibung'),
					'field' => 'TextareaField'),
			));









			$EmploymentField = new GridField(
				'Employments',
				_t('KOCH.Employments', 'Mietkoch-Einsätze'),
				$Cook->Employments(),
				GridFieldConfig::create()
					->addComponent(new GridFieldButtonRow('before'))
					->addComponent(new GridFieldTitleHeader())
					->addComponent(new GridFieldEditableColumns())
					->addComponent(new GridFieldDeleteAction())
					->addComponent(new GridFieldAddNewInlineButton())
					->addComponent(new GridFieldOrderableRows('SortOrder'))
			);
			DateField::set_default_config('showcalendar', true);
			$EmploymentField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
				'StartDate' => array(
					'title' => _t('KOCH.StartDate', 'Von') ,
					'callback' => function ($record, $column, $holiDayGridfield){
						return DateField::create('StartDate',_t('KOCH.StartDate', 'Von') )->setConfig('showcalendar', true)->setConfig('dateformat', 'dd.MM.yyyy')->setAttribute('placeholder', 'DD.MM.YYYY');
					}
				),
				'EndDate' => array(
					'title' => _t('KOCH.EndDate', 'Bis'),
					'callback' => function ($record, $column, $holiDayGridfield){
						return DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('showcalendar', true)->setConfig('dateformat', 'dd.MM.yyyy')->setAttribute('placeholder', 'DD.MM.YYYY');
					}
				),
				'Description' => array (
					'title' => _t('KOCH.Description', 'Job-Beschreibung'),
					'field' => 'TextareaField'),
			));



			$fields = new FieldList(
				HeaderField::create('TitleSkills', _t('KOCH.TitleSkills', 'Kenntnisse'), 3) ,
				ListboxField::create('Languages', _t('KOCH.Languages', 'Sprachen'), $Cook->ConfigurationSet()->Languages()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true')
			);


			if( $Cook->isCandidate ){
				$fields->push( DropDownField::create('CurrentJobID', _t('KOCH.CurrentJob', 'Derzeitige Position'), $Cook->ConfigurationSet()->Positions()->map('ID','Title__de_DE')->toArray())->setEmptyString(_t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true') );
				$fields->push( ListboxField::create('DesiredPosition', _t('KOCH.DesiredPosition', 'Wunschpositinen'), $Cook->ConfigurationSet()->Positions()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true') );
			}

			$fields->push( ListboxField::create('Skills', _t('KOCH.Skills', 'Spezialkenntnise'), $Cook->ConfigurationSet()->Skills()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true') );
			$fields->push( ListboxField::create('LeadershipExperience', _t('KOCH.LeadershipExperience', 'Führungserfahrung'), $Cook->ConfigurationSet()->LeadershipExperience()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true') );
			$fields->push( ListboxField::create('LeadershipEvents', _t('KOCH.LeadershipEvents', 'Leitung von Events '), $Cook->ConfigurationSet()->LeadershipEvents()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true') );
			$fields->push( ListboxField::create('Reports', _t('KOCH.Reports', 'Raportsysteme'), $Cook->ConfigurationSet()->Reports()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true') );
 			$fields->push( HeaderField::create('TitleCV', _t('KOCH.TitleCV', 'Lebenslauf'), 3)->setAttribute("data-chosen", 'true') );
			$fields->push( $CVField );

			$fields->push( UploadField::create('CVFile', _t('KOCH.CVFile', 'Laden Sie alternativ – oder zusätzlich – Ihren bereits erstellten Lebenslauf als PDF hoch.'))
				->setThumbnailHeight(100)
				->setThumbnailWidth(100)
				->setAcceptedFiles(array('.pdf','.doc','.docx'))
				->setPermissions(array(
					'delete' => false,
					'detach' => true)));	







			if( $Cook->isRental ){
				$fields->push( HeaderField::create('TitleEmployment', _t('KOCH.Employments', 'Mietkoch-Einsätze'), 3) );
				$fields->push( $EmploymentField );
			}

			$actions = new FieldList(
				FormAction::create('StoreCookData',_t('KOCH.Save', 'Änderungen speichern'))->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom($Cook);
			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');
			return $form;
		}




		public function CookDocumentsForm() {

			$Cook = Member::get()->byID(Security::getCurrentUser()->ID);

			$fields = new FieldList();

			if( $Cook->isCandidate ){
				$fields->push( HeaderField::create('TitleCertificates', _t('KOCH.TitleCertificates', 'Zeugnisse'), 3) );
				$fields->push( UploadField::create('Certificates', _t('KOCH.Certificates', 'Zeugnisse'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setMultiple(true)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)));
			}

			if( $Cook->isRental ){
				$fields->push( HeaderField::create('TitleRentalDocuments', _t('KOCH.TitleRentalDocuments', 'Dokumente'), 3) );
				$fields->push( UploadField::create('BusinessLicense', _t('KOCH.BusinessLicense', 'Gewerbeschein'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)));	

				$fields->push( UploadField::create('IdentityCard', _t('KOCH.IdentityCard', 'Personalausweiß (Vorder- und Rückseite)'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setMultiple(true)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)));	

				$fields->push( UploadField::create('HealthiInsuranceCard', _t('KOCH.HealthiInsuranceCard', 'Krankenversicherungskarte (Vorder- und Rückseite)'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setMultiple(true)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)));	

				$fields->push( UploadField::create('HACCPDetection', _t('KOCH.HACCPDetection', 'HACCP Nachweis '))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)));	

				$fields->push( UploadField::create('ExemptionPensionInsurance', _t('KOCH.ExemptionPensionInsurance', 'Freistellung Rentenversicherung'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)));	

			}

			$actions = new FieldList(
				FormAction::create('StoreCookData',_t('KOCH.Save', 'Änderungen speichern'))->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom($Cook);
			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');
			return $form;
		}

		public function StoreCookData($data, $form) {
			$member = Member::get()->byId(Security::getCurrentUser()->ID);
			$form->saveInto($member);
			$member->write();      
			return $this->redirectBack();
		}



		public function EmployerAddressForm(){




			$Employer = Member::get()->byID(Security::getCurrentUser()->ID);

			$billingaddresssection = Wrapper::create(
				TextField::create('BillingAddressCompany', _t('ARBEITGEBER.BillingAddressCompany', 'Firma')),
				TextField::create('BillingAddressStreet', _t('ARBEITGEBER.BillingAddressStreet', 'Adresse')),
				TextField::create('BillingAddressPostalCode', _t('ARBEITGEBER.BillingAddressPostalCode', 'PLZ')),
				TextField::create('BillingAddressPlace', _t('ARBEITGEBER.BillingAddressPlace', 'Ort')),
				CountryDropdownField::create('BillingAddressCountry', _t('ARBEITGEBER.BillingAddressCountry', 'Land'))->setAttribute("data-chosen", 'true') 
			)
			->hideIf("BillingAddressIsCompanyAddress")->isChecked()->end();


			$fields = new FieldList(
				HeaderField::create('AdressTitle', _t('ARBEITGEBER.AdressTitle', 'Firmenadresse'), 3),
				TextField::create('Company', _t('ARBEITGEBER.Company', 'Firma')),
				TextField::create('AddressStreet', _t('ARBEITGEBER.AddressStreet', 'Adresse')),
				TextField::create('AddressPostalCode', _t('ARBEITGEBER.AddressPostalCode', 'PLZ')),
				TextField::create('AddressPlace', _t('ARBEITGEBER.AddressPlace', 'Ort')),
				CountryDropdownField::create('AddressCountry', _t('ARBEITGEBER.AddressCountry', 'Land'))->setAttribute("data-chosen", 'true') ,

				TextField::create('Email', _t('ARBEITGEBER.Email', 'E-Mail')),
				TextField::create('Telephone', _t('ARBEITGEBER.Telephone', 'Telefon')),
				TextField::create('Cipher', _t('ARBEITGEBER.Cipher', 'Chiffre')),
				HeaderField::create('BillingAdressTitle', _t('ARBEITGEBER.BillingAdressTitle', 'Rechnungsadresse'), 3),
				CheckboxField::create('BillingAddressIsCompanyAddress', _t('ARBEITGEBER.BillingAddressIsCompanyAddress', 'Rechnungsadresse ist Firmenadresse')),
				$billingaddresssection,
				HeaderField::create('ContactPersonTitle', _t('ARBEITGEBER.ContactPersonTitle', 'Ansprechparter'), 3),
				TextField::create('FirstName', _t('ARBEITGEBER.FirstName', 'Vorname')),
				TextField::create('Surname', _t('ARBEITGEBER.SurName', 'Nachname')),
				TextField::create('ContactPersonTelephone', _t('ARBEITGEBER.ContactPersonTelephone', 'Telefon')),
				TextField::create('ContactPersonMobile', _t('ARBEITGEBER.ContactPersonMobile', 'Mobil'))
//				TextField::create('ContactPersonEmail', _t('ARBEITGEBER.ContactPersonEmail', 'E-Mail')) 
			);

			$actions = new FieldList(
				FormAction::create('StoreEmployerData',_t('KOCH.Save', 'Änderungen speichern'))->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom( $Employer );

			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');

			return $form;
		}



		public function EmployerPortraitForm(){

			$Employer = Member::get()->byID(Security::getCurrentUser()->ID);

			$fields = new FieldList(
				UploadField::create('Picture', _t('ARBEITGEBER.Picture', 'Logo'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setPermissions(array(
						'delete' => false,
						'detach' => true)),


				HeaderField::create('TitleSocial', _t('ARBEITGEBER.TitleSocial', 'Online Kanäle'), 3), 
				TextField::create('Homepage', _t('ARBEITGEBER.Homepage', 'Homepage')), 
				TextField::create('SocialFacebook', _t('ARBEITGEBER.SocialFacebook', 'Facebook')), 
				TextField::create('SocialTwitter', _t('ARBEITGEBER.SocialTwitter', 'Twitter')), 
				TextField::create('SocialInstagram', _t('ARBEITGEBER.SocialInstagram', 'Instagram')), 
				TextField::create('SocialPinterest', _t('ARBEITGEBER.SocialPinterest', 'Pinterest')), 



				HeaderField::create('TitleOffers', _t('ARBEITGEBER.TitleOffers', 'Angebot'), 3), 



				ListboxField::create('Offers', _t('ARBEITGEBER.Offers', 'Was wir bieten'), $Employer->ConfigurationSet()->Offers()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true'), 
				ListboxField::create('Infrastructure', _t('ARBEITGEBER.Infrastructure', 'Infrastruktur'), $Employer->ConfigurationSet()->Infrastructure()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true'), 
				TextareaField::create('ReasonWhy', _t('ARBEITGEBER.ReasonWhy', 'Warum sollten Sie bei uns arbeiten?'))->setAttribute('data-tinymce', true)
			);

			$actions = new FieldList(
				FormAction::create('StoreEmployerData',_t('KOCH.Save', 'Änderungen speichern'))->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom( $Employer );

			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');

			return $form;
		}



		public function EmployerAdvertisementsForm(){

			$Employer = Member::get()->byID(Security::getCurrentUser()->ID);



			$EmployerAdvertisementFieldGridFieldConfig = GridFieldConfig_RecordEditor::create();
			$EmployerAdvertisementFieldGridFieldConfig->removeComponentsByType('GridFieldAddExistingAutocompleter');
			$EmployerAdvertisementFieldGridFieldConfig->removeComponentsByType('GridFieldDeleteAction');
			$EmployerAdvertisementFieldGridFieldConfig->removeComponentsByType('GridFieldPaginator');
			$EmployerAdvertisementFieldGridFieldConfig->removeComponentsByType('GridFieldPageCount');
			$EmployerAdvertisementFieldGridFieldConfig->removeComponentsByType('GridFieldSortableHeader');
			$EmployerAdvertisementFieldGridFieldConfig->removeComponentsByType('GridFieldToolbarHeader');
			$EmployerAdvertisementFieldGridFieldConfig->addComponent( new GridFieldTitleHeader() );

 
			$EmployerAdvertisementFieldGridFieldConfig->getComponentByType(GridFieldDataColumns::class)->setFieldFormatting(array(
				'StartDate' => 'dd.mm.YYYY'
			));



			$EmployerAdvertisementField = new GridField(
				'EmployerAdvertisements',
				_t('KOCH.EmployerAdvertisement', 'Inserate'),
				$Employer->EmployerAdvertisements(),
				$EmployerAdvertisementFieldGridFieldConfig
			);

			$fields = new FieldList(
				$EmployerAdvertisementField

			);

			$actions = new FieldList(
				
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);
			$form->loadDataFrom( $Employer );

			$form->sessionMessage(_t('KOCH.ChangesSaved', 'Ihre Änderungen wurden erfolgreich gespeichert'), 'good');

			return $form;
		}


		public function StoreEmployerData($data, $form) {
			$member = Member::get()->byId(Security::getCurrentUser()->ID);
			$form->saveInto($member);
			$member->write();      
			return $this->redirectBack();
		}










		public function RegistrationForm( $MemberID = 0 ){

			if( $MemberID && $MemberID > 0 ){
				$fields = new FieldList(
					TextField::create('Email', _t('REGISTRATION.Email', 'E-Mail')),
					PasswordField::create('Password', _t('REGISTRATION.ChoosePassword', 'Gewünschtes Passwort')),
					PasswordField::create('RepeatPassword', _t('REGISTRATION.RepeatPassword', 'Passwort wiederholen')),
					LiteralField::create('Accepted' , '<div class="field"><label><input type="checkbox" required name="legal-accept" />Hiermit bestätige ich, dass ich sowohl die <a href="/rechtliches/datenschutz/" target="_blank">Datenschutzerklärung</a> wie auch die <a href="/rechtliches/agb/" target="_blank">AGB</a> gelesen habe und mit beiden einverstanden bin. *</label></div>' ),
					HiddenField::create('MemberGroup', 'Membergroup')->setValue(  $MemberID )
				);
			}else{
				$fields = new FieldList(
					TextField::create('Email', _t('REGISTRATION.Email', 'E-Mail')),
					PasswordField::create('Password', _t('REGISTRATION.ChoosePassword', 'Gewünschtes Passwort')),
					PasswordField::create('RepeatPassword', _t('REGISTRATION.RepeatPassword', 'Passwort wiederholen')),
					OptionsetField::create('MemberGroup', _t('REGISTRATION.MemberGroup', 'Ich bin...'), array(
						'4' => '... ein Koch und möchte einen passenden Job finden.',
						'5' => '... ein Arbeitgeber und suche passende Mitarbeiter/Innen'
					)),
					LiteralField::create('Accepted' , '<div class="field"><label><input type="checkbox" required name="legal-accept" />Hiermit bestätige ich, dass ich sowohl die <a href="/rechtliches/datenschutz/" target="_blank">Datenschutzerklärung</a> wie auch die <a href="/rechtliches/agb/" target="_blank">AGB</a> gelesen habe und mit beiden einverstanden bin. *</label></div>' )
				);
			}



			$actions = new FieldList(
				FormAction::create('CreateEmployer',_t('KOCH.Save', 'Kostenlos registrieren'))->setUseButtonTag(true)
			);

			$form = new Form($this, __FUNCTION__, $fields, $actions);


			$required = new RequiredFields([
				'Email', 'Password', 'MemberGroup'
			]);
			$form->setValidator($required);

//			$form->disableSecurityToken();


//			$form->sessionMessage(_t('KOCH.Created', 'Ihr Konto wurde erfolgreich erstellt. Sie erhateln in Kürze eine E-mial mit Bestätigungslink.'), 'good');

			return $form;
		}




		public function CreateEmployer($data, $form) {

//			if( $data['Password'] == $data['RepeatPassword'] ){
				if( $data['MemberGroup'] == '4' ){
					$member = Cook::create();
				}elseif ( $data['MemberGroup'] == '5' ) {
					$member = Employer::create();
				}
//			}

			$member->Email = $data['Email'];
			$member->changePassword($data['Password']);

			$member->login();

			$member->write();      
			return $this->redirect('/mein-koecheportal');
		}










    }

