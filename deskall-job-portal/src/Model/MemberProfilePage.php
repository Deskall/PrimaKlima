<?php

use SilverStripe\Security\Group;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Security\Security;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DB;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Subsite\Subsite;

class MemberProfilePage extends Page {
	

	private static $has_one = [
		'Group' => Group::class
	];

	private static $groupcodes = ['kandidaten','arbeitgeber'];

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Profile', DropdownField::create('GroupID',_t(__CLASS__.'.Group','Benutzer Grupp'), Group::get()->filter('Code',$this->stat('groupcodes'))->map('ID','Title'))->setEmptyString('Grupp wählen'));
		
		return $fields;
	}

	public function canCreate( $member = null, $context = []){
	    // if (!MemberProfilePage::get()->filter('SubsiteID',Subsite::currentSubsiteID())->first()){
	    // 	return true;
	    // }
	    // return false;
	    return true;
	}


    public function getCookConfig(){
    	return CookConfig::get()->first();
    }



	public function Missions(){
		return Mission::get()->filter('isVisible',1)->sort('Sort');
		// return Mission::get()->filter('Status','sentToCook');
	}

	



}