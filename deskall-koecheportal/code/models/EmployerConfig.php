<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\DropDownField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddNewInlineButton;

class EmployerConfig extends DataObject{

	private static $db = array(
		'Title__de_DE' => 'Varchar(255)'
	);

	private static $summary_fields = array(
		'Title__de_DE' => 'Titel',
	);

	private static $many_many = array(
		'Offers' => 'EmloyerConfigItem',
		'Infrastructure' => 'EmloyerConfigItem',
	);

	private static $many_many_extraFields = array(
		'Offers' => array('SortOrder' => 'Int'),
		'Infrastructure' => array('SortOrder' => 'Int'),
	);


	private static $singular_name = 'Konfiguration';
	private static $plural_name = 'Konfigurationen';



	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(new TabSet('Root'));
		$fields->addFieldToTab('Root.Main', TextField::create('Title__de_DE', _t('ARBEITGEBER.Title', 'Titel')) );
		$OffersField = GridField::Create(
			'Offers',
			_t('ARBEITGEBER.Offers', 'Was bieten Sie?'),
			$this->Offers(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$OffersField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'Angebot',
				'field' => TextField::class),
		));


		$InfrastructureField = GridField::Create(
			'Infrastructure',
			_t('ARBEITGEBER.Infrastructure', 'Infrastruktur'),
			$this->Infrastructure(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$InfrastructureField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'Infrastruktur',
				'field' => TextField::class),
		));


		$fields->addFieldToTab('Root.Main', HeaderField::create('OffersTitle', 'Was bieten Sie?', 3) );
		$fields->addFieldToTab('Root.Main', $OffersField );


		$fields->addFieldToTab('Root.Main', HeaderField::create('InfrastructureTitle', 'Infrastruktur', 3) );
		$fields->addFieldToTab('Root.Main', $InfrastructureField );


		return $fields;
	}





}
