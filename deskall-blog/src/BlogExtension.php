<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class BlogExtension extends DataExtension{

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
		$fields->addFieldsToTab('Root.PostOptions',[
			CheckboxField::create('displayEntryMeta',$this->owner->fieldLabels(false)['displayEntryMeta']),
			CheckboxField::create('displayCommentsCount',$this->owner->fieldLabels(false)['displayCommentsCount']),
			CheckboxField::create('displayShareButtons',$this->owner->fieldLabels(false)['displayShareButtons'])
		]);
		$fields->FieldByName('Root.PostOptions')->setTitle(_t('Blog.TabOptions','Optionen'));
		$fields->FieldByName('Posts')->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));
	}

	public function checkLead(){
		return false;
	}
}