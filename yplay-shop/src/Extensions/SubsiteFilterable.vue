<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Control\Cookie;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\Subsites\Model\Subsite;

class SubsiteFilterable extends DataExtension
{

    private static $has_one = ['Subsite' => Subsite::class];

    public function updateFieldLabels(&$labels){
        $labels['SubsiteID'] = 'Partner Subsite';
    }

    public function updateCMSFields(FieldList $fields){
       $fields->removeByName('SubsiteID');
       $fields->push(new HiddenField('SubsiteID','SubsiteID', SubsiteState::singleton()->getSubsiteId()));
    }
}