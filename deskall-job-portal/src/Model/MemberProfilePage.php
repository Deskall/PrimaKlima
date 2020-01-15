<?php

use SilverStripe\Security\Group;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
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
	
	public function canCreate( $member = null, $context = []){
	    if (MemberProfilePage::get()->count() == 0){
	    	return true;
	    }
	    return false;
	}


	public function Missions(){
		return Mission::get()->filter('isVisible',1)->sort('Sort');
	}

	
	public function changePasswordLink(){
		return Security::changePassword();
	}

	



}