<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Subsite\Subsite;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Subsite\Subsite\SubsiteState;

class Subsitable extends DataExtension
{

    private static $has_one = [
        'Subsite' => 'Subsite'
    ];

    public function updateCMSFields(FieldList $fields){
    	if(class_exists(Subsite::class)){
			$fields->push(new HiddenField('SubsiteID','SubsiteID', SubsiteState::singleton()->getSubsiteId()));
		}
    }

}