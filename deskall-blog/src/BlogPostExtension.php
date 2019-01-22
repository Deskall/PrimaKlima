<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;

class BlogPostExtension extends DataExtension{

	private static $db = [
		'displayEntryMeta' => 'Boolean(0)',
		'displayCommentsCount' => 'Boolean(0)',
		'displayShareButtons' => 'Boolean(0)'
	];

	public function updateFieldLabels(&$labels){
		$labels['displayEntryMeta'] = _t('BlogPost.DisplayEntryMeta','Artikel Infos anzeigen?');
		$labels['displayCommentsCount'] = _t('BlogPost.displayCommentsCount','Kommentare Zahl anzeigen?');
		$labels['displayShareButtons'] = _t('BlogPost.displayShareButtons','Share Button anzeigen?');
	}

	public function updateCMSFields(FieldList $fields){
		$fields->FieldByName('Root.Main.FeaturedImage')->setFolderName($this->owner->generateFolderName());
	}

	public function checkLead(){
		return false;
	}

}