<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;

class BlogCategoryExtension extends DataExtension{

	private static $has_one = ['Image' => Image::class];

	private static $owns = ['Image'];

	public function updateCMSFields(FieldList $fields){
	 $fields->addFieldToTab('Root.Main',UploadField::create('Image','Image')->setFolderName('Uploads/Blog/'.$this->owner->Blog()->URLSegment));
	}

}