<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;

class PageLayoutExtension extends DataExtension {

	private static $db = [
	  'ExtraCSSClass' => 'Varchar',
	  'ExtraHeaderClass' => 'Varchar',
	  'ExtraMenuClass' => 'Varchar',
	  'MenuIcon' => 'Varchar(255)'
	];

	public function updateFieldLabels(&$labels){
	  
	  $labels['ExtraCSSClass'] = _t('Page.ExtraCssClass','Custom CSS Class für die Seite');
	  $labels['ExtraHeaderClass'] = _t('Page.ExtraHeaderClass','Custom CSS Class für der Header');
	  $labels['ExtraMenuClass'] = _t('Page.ExtraMenuClass','Custom CSS Class für der Menü');
	  $labels['MenuIcon'] = _t('Page.MenuIcon','Icon für Menü');
	}


	public function updateCMSFields(FieldList $fields){
	 
	  $fields->addFieldToTab('Root.Layout',TextField::create('ExtraCSSClass',$this->owner->fieldLabels()['ExtraCSSClass']));
	  $fields->addFieldToTab('Root.Layout',TextField::create('ExtraHeaderClass',$this->owner->fieldLabels()['ExtraHeaderClass']));
	  $fields->addFieldToTab('Root.Layout',TextField::create('ExtraMenuClass',$this->owner->fieldLabels()['ExtraMenuClass']));
	  $fields->addFieldToTab('Root.Layout', HTMLDropdownField::create('MenuIcon',$this->owner->fieldLabels()['MenuIcon'], HTMLDropdownField::getSourceIcones(), 'check')->addExtraClass('columns'));

	  
	}
}