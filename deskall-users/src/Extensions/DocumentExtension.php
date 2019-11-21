<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Folder;
use SilverStripe\Security\Security;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Group;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Control\Director;

class DocumentExtension extends DataExtension{
	private static $db = ['Description' => 'HTMLText', 'isSecure' => 'Boolean'];

	private static $many_many = ['Readers' => Member::class];

	public function onBeforeWrite(){
		parent::onBeforeWrite();
	}


	public function PossibleReaders(){
		return Group::get()->filter('Code','Mitarbeiter')->first()->Members();
	}

	public function RootFolder(){
		$parent = $this->owner->Parent();
		if ($parent){
			while($parent->ParentID > 0){
				$parent = $parent->Parent(); 
			}
		}
		
		return $parent;
	}

	public function InternLink(){
		return 'admin/assets/show/'.$this->owner->ParentID.'/edit/'.$this->owner->ID;
	}

	public function canView($member = null){
		if ($this->RootFolder()->Name == "Secure" ){
			$member = Security::getCurrentUser();
			if ($member && $member->ID == $this->owner->OwnerID){
				return true;
			}
			if ($this->owner->ClassName == Folder::class){
				foreach ($this->owner->Children() as $child) {
					if ($child->canView()){
						return true;
					}
				}
			}
			if ($this->owner->Readers()->find('ID',$member->ID)){
				return true;
			}
			return (Permission::check('ADMIN'));
		}
		return true;
	}

	public function ConsultDocumentLink(){
		return Director::AbsoluteURL('secure/download/'.$this->owner->ID);
	}


    public function onAfterUpload(){
        
        $this->owner->write();
        $this->owner->publishSingle();
    }
}