<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class BlogPostExtension extends DataExtension{

	public function updateCMSFields(FieldList $fields){
		$fields->FieldByName('Root.Main.FeaturedImage')->setFolderName($this->owner->generateFolderName());
	}

	public function checkLead(){
		return false;
	}

}