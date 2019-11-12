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

class Cook extends Member {

	private static $db = array(
		'Address' => 'Varchar(255)',
		'PostalCode' => 'Varchar(255)',
		'Place' => 'Varchar(255)',
		'Country' => 'Varchar(255)',
		'Mobile' => 'Varchar(255)',
		'MaritalStatus' => 'Varchar(255)',
		'isRental' => 'Boolean',
		'isCandidate' => 'Boolean',
	);

	private static $has_one = array(
		'ConfigurationSet' => CookConfig::class,
		'Picture' => Image::class,
		'BusinessLicense' => File::class,
		'BusinessLicense' => File::class,
		'HACCPDetection' => File::class,
		'ExemptionPensionInsurance' => File::class,
		'CurrentJob' => CookConfigItem::class,
		'CVFile' => File::class,
	);

	private static $has_many = array(
		'CVItmes' => CookCVItem::class,
		'Employments' => CookEmployment::class,
	);

	private static $many_many = array(
		'IdentityCard' => File::class,
		'HealthiInsuranceCard' => File::class,
		'Certificates' => File::class,
		'Languages' => CookLanguageConfigItem::class,
		'DesiredPosition' => CookConfigItem::class,
		'Skills' => CookConfigItem::class,
		'LeadershipExperience' => CookConfigItem::class,
		'LeadershipEvents' => CookConfigItem::class,
		'Reports' => CookConfigItem::class,
	);





	private static $many_many_extraFields = array(
		'IdentityCard' => array('SortOrder' => 'Int'),
		'HealthiInsuranceCard' => array('SortOrder' => 'Int')
	);

	private static $defaults = array('ConfigurationSetID' => 1, 'isCandidate' => true);



	private static $summary_fields = array(
		'generateClientNumber' => 'Kundennummer',
		'FirstName' => 'Vorname',
		'Surname' => 'Nachname',
		'Email' => 'E-Mail',
	);



	private static $singular_name = 'Koch';

	private static $plural_name = 'Köche';


	public function generateClientNumber(){
		$SiteConfig = SiteConfig::current_site_config();
		return number_format ( $this->ID + $SiteConfig->ClientNumberOffset , 0 ,  "." ,  "." );
	}	





	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(new TabSet('Root'));

		$fields->removeByName('Picture');
		$fields->removeByName('BusinessLicense');


		$fields->addFieldToTab('Root.Personalien', CheckboxField::create('EmailConfirmed', _t('ARBEITGEBER.EmailConfirmed', 'Bestätigen')) );	

		// Bein Personal Data

		$fields->addFieldToTab('Root.Personalien', UploadField::create('Picture', _t('KOCH.Picture', 'Porträt'))->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif') ));
		$fields->addFieldToTab('Root.Personalien', TextField::create('FirstName', _t('KOCH.FirstName', 'Vorname')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('Surname', _t('KOCH.SurName', 'Nachname')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('MaritalStatus', _t('KOCH.MaritalStatus', 'Familienstand ')) );
		$fields->addFieldToTab('Root.Personalien', HeaderField::create('ContactTitle', _t('KOCH.ContactTitle', 'Kontaktangaben'), 3) );	
		$fields->addFieldToTab('Root.Personalien', TextField::create('Address', _t('KOCH.Address', 'Adresse')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('PostalCode', _t('KOCH.PostalCode', 'PLZ')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('Place', _t('KOCH.Place', 'Ort')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('Country', _t('KOCH.Country', 'Land')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('Email', _t('KOCH.Email', 'E-Mail')) );
		$fields->addFieldToTab('Root.Personalien', TextField::create('Mobile', _t('KOCH.Mobile', 'Mobile')) );

		// End Personal Data




		// Begin Professional Daa

		$CVField = new GridField(
			'CVItmes',
			_t('KOCH.ProfessionalExperiences', 'Berufliche Erfahrungen'),
			$this->CVItmes(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);
		DateField::set_default_config('showcalendar', true);
		$CVField->getConfig()->getComponentByType('GridFieldEditableColumns')->setDisplayFields(array(
			'StartDate' => array(
				'title' => _t('KOCH.StartDate', 'Von'),
				'callback' => function ($record, $column, $holiDayGridfield){
					return DateField::create('StartDate', _t('KOCH.StartDate', 'Von'))->setConfig('showcalendar', true)->setConfig('dateformat', 'yyyy/MM');
				}
			),
			'EndDate' => array(
				'title' => _t('KOCH.EndDate', 'Bis'),
				'callback' => function ($record, $column, $holiDayGridfield){
					return DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('showcalendar', true)->setConfig('dateformat', 'yyyy/MM');
				}
			),
			'Description' => array (
				'title' => _t('KOCH.Description', 'Job-Beschreibung'),
				'field' => 'TextareaField'),
		));

		$EmploymentField = new GridField(
			'Employments',
			_t('KOCH.Employments', 'Mietkoch-Einsätze'),
			$this->Employments(),
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
					return DateField::create('StartDate',_t('KOCH.StartDate', 'Von') )->setConfig('showcalendar', true)->setConfig('dateformat', 'dd.MM.yyyy');
				}
			),
			'EndDate' => array(
				'title' => _t('KOCH.EndDate', 'Bis'),
				'callback' => function ($record, $column, $holiDayGridfield){
					return DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'))->setConfig('showcalendar', true)->setConfig('dateformat', 'dd.MM.yyyy');
				}
			),
			'Description' => array (
				'title' => _t('KOCH.Description', 'Job-Beschreibung'),
				'field' => 'TextareaField'),
		));

		$fields->addFieldToTab('Root.BeruflicheAngaben', CheckboxField::create('isRental', _t('KOCH.isRental', 'Ist als Mietkoch verfügbar')) );
		$fields->addFieldToTab('Root.BeruflicheAngaben', CheckboxField::create('isCandidate', _t('KOCH.isCandidate', 'Ist als Bewerber verfügbar')) );

		$fields->addFieldToTab('Root.BeruflicheAngaben', HeaderField::create('TitleSkills', _t('KOCH.TitleSkills', 'Kenntnisse'), 3) );
		$fields->addFieldToTab('Root.BeruflicheAngaben', ListboxField::create('Languages', _t('KOCH.Languages', 'Sprachen'), $this->ConfigurationSet()->Languages()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte Wählen')) );


		$fields->addFieldToTab("Root.BeruflicheAngaben", Wrapper::create(
				DropDownField::create('CurrentJobID', _t('KOCH.CurrentJob', 'Derzeitige Position'), $this->ConfigurationSet()->Positions()->map('ID','Title__de_DE')->toArray())->setEmptyString(_t('KOCH.Choose', 'Bitte Wählen')),
				ListboxField::create('DesiredPosition', _t('KOCH.DesiredPosition', 'Wunschpositinen'), $this->ConfigurationSet()->Positions()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte Wählen'))
			)
			->displayIf("isCandidate")->isChecked()->end()
		);

		$fields->addFieldToTab('Root.BeruflicheAngaben', ListboxField::create('Skills', _t('KOCH.Skills', 'Spezialkenntnise'), $this->ConfigurationSet()->Skills()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte Wählen')) );
		$fields->addFieldToTab('Root.BeruflicheAngaben', ListboxField::create('LeadershipExperience', _t('KOCH.LeadershipExperience', 'Führungserfahrung'), $this->ConfigurationSet()->LeadershipExperience()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte Wählen')) );
		$fields->addFieldToTab('Root.BeruflicheAngaben', ListboxField::create('LeadershipEvents', _t('KOCH.LeadershipEvents', 'Leitung von Events '), $this->ConfigurationSet()->LeadershipEvents()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte Wählen')) );
		$fields->addFieldToTab('Root.BeruflicheAngaben', ListboxField::create('Reports', _t('KOCH.Reports', 'Raportsysteme'), $this->ConfigurationSet()->Reports()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('KOCH.Choose', 'Bitte Wählen')) );
 		$fields->addFieldToTab('Root.BeruflicheAngaben', HeaderField::create('TitleCV', _t('KOCH.TitleCV', 'Lebenslauf'), 3) );
		$fields->addFieldToTab('Root.BeruflicheAngaben', $CVField );


		$fields->addFieldToTab("Root.BeruflicheAngaben", Wrapper::create(
				HeaderField::create('TitleEmployment', _t('KOCH.Employments', 'Mietkoch-Einsätze'), 3),
				$EmploymentField
			)
			->displayIf("isRental")->isChecked()->end()
		);

		// End Professional Data




		// Begin Documents

		$fields->addFieldToTab("Root.Dokuemnte", Wrapper::create(
				HeaderField::create('TitleCertificates', _t('KOCH.TitleCertificates', 'Zeugnisse'), 3),
				SortableUploadField::create('Certificates', _t('KOCH.Certificates', 'Zeugnisse'))
			)
			->displayIf("isCandidate")->isChecked()->end()
		);

		$fields->addFieldToTab("Root.Dokuemnte", Wrapper::create(
				HeaderField::create('TitleRentalDocuments', _t('KOCH.TitleRentalDocuments', 'Dokumente'), 3),
				UploadField::create('BusinessLicense', _t('KOCH.BusinessLicense', 'Gewerbeschein')),
				SortableUploadField::create('IdentityCard', _t('KOCH.IdentityCard', 'Personalausweiß (Vorder- und Rückseite)')), 
				SortableUploadField::create('HealthiInsuranceCard', _t('KOCH.HealthiInsuranceCard', 'Krankenversicherungskarte (Vorder- und Rückseite)')),
				UploadField::create('HACCPDetection', _t('KOCH.HACCPDetection', 'HACCP Nachweis ')), 
				UploadField::create('ExemptionPensionInsurance', _t('KOCH.ExemptionPensionInsurance', 'Freistellung Rentenversicherung'))
			)
			->displayIf("isRental")->isChecked()->end()
		);

		// End Docuemnts


		return $fields;
	}


	public function hasAppliedFor( $EmployerID ){


		return sizeof( CookApplication::get()->filter(array(
			'CookID' => $this->ID,
			'EmployerAdvertisement.EmployerID' => $EmployerID 
		))->toArray() ) > 0;

	}


	public function isMe(){
		return Security::getCurrentUser()->ID == $this->ID;
	}




}
