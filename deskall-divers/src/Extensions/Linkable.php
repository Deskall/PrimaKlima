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

    public function onAfterDuplicate($doWrite = true, $relations = false){
    	$link = $this->owner->LinkableLink();
    	$newLink = $link->duplicate(true,true);
        file_put_contents('log.txt', $newLink->ID);
    	$this->owner->LinkableLinkID = $newLink->ID;
    	$this->owner->write();
    }

}