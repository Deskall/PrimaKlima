<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;

class NewsTemplate extends DataObject {
	private static $singular_name = 'Vorlage';
	private static $plural_name = 'Vorlagen';

	private static $db = array(
		'Title' => 'Varchar(250)',
		'Lead' => 'Text',
	);

	private static $extensions = [
	  'Sortable',
	  'Subsitable'
	];

    private static $summary_fields = array (
      'Title' => array('title' => 'Titel'),
      'Lead' => 'Text'
    );


	public function getCMSFields() {
		$fields = parent::getCMSFields(); 

		$fields->addFieldToTab('Root.Main', TextField::create('Title', 'Titel')); 
		$fields->addFieldToTab('Root.Main', TextareaField::create('Lead', 'Vorschau Text')); 


		return $fields;
	}

	// public function canCreate($member = null, $context = []){
	//     if (Permission::check('ADMIN')){
	//         return true;
	//     }
	//     return false;
	// }

	// public function canView($member = null){
	//     return $this->canCreate($member);
	// }

	// public function canEdit($member = null){
	//     $member = Member::currentUser();
	//     if ($this->ID == 0 || $this->SubsiteID == $member->SubsiteID){
	//         return true;
	//     }
	//     return false;
	// }


	// public function canDelete($member = null)
	// {
	//     return $this->canEdit($member);
	// }
}