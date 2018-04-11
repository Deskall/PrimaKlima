<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class DeskallFormStepExtension extends DataExtension{
	private static $db = ['Icon' => 'Varchar(255)'];

	public function updateCMSFields(FieldList $fields){
		$fields->addFieldToTab('Root.Main',new HTMLDropdownField('Icon', _t(__CLASS__.'.Icone','Icon'), HTMLDropdownField::getSourceIcones(), 'check'));
	}
	
}