<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBText;

class BlogPostExtension extends DataExtension{

	private static $db = [
	
	];

	private static $default_sort = "\"Sort\"";

	public function updateFieldLabels(&$labels){
		
	}

	public function updateCMSFields(FieldList $fields){
		$fields->FieldByName('Root.Main.FeaturedImage')->setFolderName($this->owner->generateFolderName());
	}

	public function checkLead(){
		return false;
	}

	public function SummaryFromBlocks(){
		$blocks = $this->owner->ElementalArea()->Elements()->filter('ClassName', ['LeadBlock','TextBlock']);
		$content = '';
		foreach ($blocks as $block) {
			$content .= strip_tags($block->HTML);
		}
		$o = DBText::create();
		$o->setValue($content);
		return $o;
	}

	public function RealMinutesToRead($wpm = null)
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