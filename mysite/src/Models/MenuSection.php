<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Sheadawson\Linkable\Forms\LinkField;

class MenuSection extends DataObject{

	private static $db = [
		'Title' => 'Varchar(255)'
	];

	private static $has_one = [
		'Page' => SiteTree::class
	];

	private static $has_many = [
		'Links' => MenuSectionLink::class
	];

	private static $owns = ['Links'];


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Links'] = 'Links';
	 
	    return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Links');
		$fields->removeByName('PageID');
		if ($this->ID > 0){
			$config = GridFieldConfig_RecordEditor::create();
			// $config->removeComponentsByType(GridFieldAddNewButton::class);
			// $config->addComponent(new GridFieldEditableColumns())->addComponent(new GridFieldAddNewInlineButton());
			// $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			// 	'SecondField' => array(
			// 		'title' => 'Link',
			// 		'field' => LinkField::class
			// 	)
			// ));
			$fields->addFieldToTab('Root.Main',
				GridField::create('Links','Links',$this->Links(),$config)
			);
		}
		

		
		

		return $fields;
	}

	
}