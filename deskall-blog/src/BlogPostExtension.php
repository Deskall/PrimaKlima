<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBHTMLText;

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
		$o = DBHTMLText::create();
		$o->setValue($html);
		return $o;
	}

	public function MinutesToRead($wpm = null)
	{
	    $wpm = $wpm ?: $this->owner->config()->get('minutes_to_read_wpm');

	    if (!is_numeric($wpm)) {
	        throw new \InvalidArgumentException(sprintf("Expecting integer but got %s instead", gettype($wpm)));
	    }
	    $content = '';
	    foreach ($this->owner->ElementalArea()->Elements()->filter('isVisible',1) as $block) {
	    	if ($block->HTML){
	    		$content .= $block->HTML;
	    	}
	    	if ($block->Content){
	    		$content .= $block->content;
	    	}
	    }
	    $wordCount = str_word_count(strip_tags($content));

	    if ($wordCount < $wpm) {
	        return 0;
	    }

	    return round($wordCount / $wpm, 0);
	}

}