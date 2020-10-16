<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ManyManyList;

class BlogPostExtension extends DataExtension{

	private static $db = [
	
	];

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

	/** Provide similar article with same Tags or Categories **/
	public function OtherBlogPosts(){
		$blogposts = DataList::create(BlogPost::class)
		//First Tags
		if ($this->owner->Tags()->exists()){
			$tags = $this->owner->Tags()->column('ID');
			$posts = ManyManyList::create(BlogPost::class, 'BlogPost_Tags','BlogPostID','BlogTagID')->filter('BlogTagID',$tags)->exclude('BlogPostID',$this->owner->ID)->limit(3);
			$blogposts->addMany($posts);
		}

		//If not enough we go through categories
		if ($blogposts->count() < 3){
			if ($this->owner->Categories()->exists()){
				$tags = $this->owner->Categories()->column('ID');
				$posts = ManyManyList::create(BlogPost::class, 'BlogPost_Categories','BlogPostID','BlogCategoryID')->filter('BlogCategoryID',$tags)->exclude('BlogPostID',$this->owner->ID)->limit(3 - $blogposts->count());
				$blogposts->addMany($posts);
			}
		}

		return $blogposts;
	}
}