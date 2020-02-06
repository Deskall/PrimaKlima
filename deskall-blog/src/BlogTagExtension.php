<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\View\Parsers\URLSegmentFilter;

class BlogTagExtension extends DataExtension{

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		$this->owner->URLSegment = URLSegmentFilter::create()->filter($this->owner->Title);
	}
}