<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;

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
		$fields->addFieldsToTab('Root.PostOptions',[
			CheckboxField::create('displayEntryMeta',$this->owner->fieldLabels(false)['displayEntryMeta']),
			CheckboxField::create('displayCommentsCount',$this->owner->fieldLabels(false)['displayCommentsCount']),
			CheckboxField::create('displayShareButtons',$this->owner->fieldLabels(false)['displayShareButtons'])
		]);
	}

	public function checkLead(){
		return false;
	}

	public function SummaryFromBlocks(){
		$blocks = $this->owner->ElementalArea()->Elements()->filter('ClassName', ['LeadBlock','TextBlock']);
		$html = '';
		foreach ($blocks as $block) {
			$html .= $block->HTML;
		}
		return $html;
	}

}