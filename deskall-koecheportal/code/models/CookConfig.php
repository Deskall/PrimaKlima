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
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddNewInlineButton;

class CookConfig extends DataObject{

	private static $db = array(
		'Title__de_DE' => 'Varchar(255)'
	);

	private static $summary_fields = array(
		'Title__de_DE' => 'Titel',
	);

	private static $many_many = array(
		'Positions' => 'CookConfigItem',
		'Skills' => 'CookConfigItem',
		'LeadershipExperience' => 'CookConfigItem',
		'LeadershipEvents' => 'CookConfigItem',
		'Reports' => 'CookConfigItem',
		'Languages' => 'CookLanguageConfigItem',
	);

	private static $many_many_extraFields = array(
		'Positions' => array('SortOrder' => 'Int'),
		'Skills' => array('SortOrder' => 'Int'),
		'LeadershipExperience' => array('SortOrder' => 'Int'),
		'LeadershipEvents' => array('SortOrder' => 'Int'),
		'Reports' => array('SortOrder' => 'Int'),


		
		'Languages' => array('SortOrder' => 'Int'),
	);





	private static $singular_name = 'Konfiguration';
	private static $plural_name = 'Konfigurationen';


	public function getCMSFields() {
		$fields = new FieldList();
		$fields->push(new TabSet('Root'));
		$fields->addFieldToTab('Root.Main', TextField::create('Title__de_DE', _t('KOCH.Title', 'Titel')) );


		$PositionsField = GridField::Create(
			'Positions',
			'Position',
			$this->Positions(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$PositionsField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'Job',
				'field' => 'TextField'),
		));

		$LanguagesField = GridField::Create(
			'Languages',
			'Sprachen',
			$this->Languages(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$LanguagesField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Code' => array (
				'title' => 'Code',
				'field' => 'TextField'),
			'Title__de_DE' => array (
				'title' => 'Titel',
				'field' => 'TextField'),
		));

		$SkillsField = GridField::Create(
			'Skills',
			'Spezialkenntnise',
			$this->Skills(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$SkillsField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'Kenntnis',
				'field' => 'TextField'),
		));


		$LeadershipExperienceField = GridField::Create(
			'LeadershipExperience',
			'Führungserfahrung ',
			$this->LeadershipExperience(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$LeadershipExperienceField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'Team geführt',
				'field' => 'TextField'),
		));

		$LeadershipEventsField = GridField::Create(
			'LeadershipEvents',
			'Leitung von Events  ',
			$this->LeadershipEvents(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$LeadershipEventsField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'für den Küchenbereich',
				'field' => 'TextField'),
		));


		$ReportsField = GridField::Create(
			'Reports',
			'Raportsysteme',
			$this->Reports(),
			GridFieldConfig::create()
				->addComponent(new GridFieldButtonRow('before'))
				->addComponent(new GridFieldTitleHeader())
				->addComponent(new GridFieldEditableColumns())
				->addComponent(new GridFieldDeleteAction())
				->addComponent(new GridFieldAddNewInlineButton())
				->addComponent(new GridFieldOrderableRows('SortOrder'))
		);

		$ReportsField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			'Title__de_DE' => array (
				'title' => 'Raportsysteme',
				'field' => 'TextField'),
		));


		$fields->addFieldToTab('Root.Main', HeaderField::create('LanguagesTitle', 'Sprachen', 3) );
		$fields->addFieldToTab('Root.Main', $LanguagesField );


		$fields->addFieldToTab('Root.Main', HeaderField::create('PositionsTitle', 'Positionen', 3) );
		$fields->addFieldToTab('Root.Main', $PositionsField );

		$fields->addFieldToTab('Root.Main', HeaderField::create('SkillsTitle', 'Spezialkenntnise', 3) );
		$fields->addFieldToTab('Root.Main', $SkillsField );

		$fields->addFieldToTab('Root.Main', HeaderField::create('LeadershipExperienceTitle', 'Führungserfahrung ', 3) );
		$fields->addFieldToTab('Root.Main', $LeadershipExperienceField );

		$fields->addFieldToTab('Root.Main', HeaderField::create('LeadershipEventsTitle', 'Leitung von Events ', 3) );
		$fields->addFieldToTab('Root.Main', $LeadershipEventsField );

		$fields->addFieldToTab('Root.Main', HeaderField::create('ReportsTitle', 'Raportsysteme ', 3) );
		$fields->addFieldToTab('Root.Main', $ReportsField );


		return $fields;
	}





}