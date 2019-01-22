<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class BlogPostExtension extends DataExtension{

	private static $db = ['displayEntryMeta' => 'Boolean(0)'];

	public function updateCMSFields(&$labels){
		$labels['displayEntryMeta'] = _t('BlogPost.DisplayEntryMeta','Artikel Infos anzeigen?');
	}

	public function updateCMSFields(FieldList $fields){
		$fields->FieldByName('Root.Main.FeaturedImage')->setFolderName($this->owner->generateFolderName());
	}

	public function checkLead(){
		return false;
	}

}