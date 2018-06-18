<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use Sheadawson\Linkable\Forms\LinkField;
use Sheadawson\Linkable\Models\Link;


class Linkable extends DataExtension
{

    private static $has_one = [
        'LinkableLink' => Link::class
    ];


    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('LinkableLinkID');
        $fields->addFieldToTab('Root.Main', LinkField::create('LinkableLinkID', _t(__CLASS__.'.CTA', 'Link')));
    }

    public function duplicate($doWrite = true, $relations = false){
    	$new = parent::duplicate();
    	$link = $this->LinkableLink();
    	$newLink = $link->duplicate();
    	$new->LinkableLinkID = $newLink->ID;
    	$new->write();
    }

}