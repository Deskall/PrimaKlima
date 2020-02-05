<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Subsites\State\SubsiteState;

class Subsitable extends DataExtension
{

    private static $has_one = [
        'Subsite' => Subsite::class
    ];

    public function updateCMSFields(FieldList $fields){
    	if(class_exists(Subsite::class)){
			$fields->push(new HiddenField('SubsiteID','SubsiteID', SubsiteState::singleton()->getSubsiteId()));
		}
    }

}