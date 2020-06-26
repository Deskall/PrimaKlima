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
	
	private static $many_many = ['MenuSections' => MenuSection::class];

	private static $owns = ['MenuSections'];

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
		$fields->addFieldToTab('Root.Layout', HTMLDropdownField::create('MenuIcon',$this->owner->fieldLabels()['MenuIcon'], HTMLDropdownField::getSourceIcones(), 'check')->setEmptyString(_t('PageLayout.IconLabel','Wählen Sie ein Icon'))->addExtraClass('columns'));

	  	$fields->removeByName('MenuSections');
	    if ($this->owner->ShowInMainMenu){
	        $fields->addFieldToTab('Root.Menu',
	            GridField::create('MenuSections','Menu Sektionen',$this->owner->MenuSections()->filter('ClassName',MenuSection::class),GridFieldConfig_RelationEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDeleteAction()))
	        );
	    }

	  
	}

	public function activeMenuSections(){
	    return $this->owner->MenuSections()->filter(['ClassName' => MenuSection::class, 'isVisible' => 1]);
	}
}


