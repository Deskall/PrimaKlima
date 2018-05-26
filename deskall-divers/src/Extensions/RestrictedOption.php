<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Security\Permission;

class RestrictedOption extends DataExtension
{


    public function updateCMSFields(FieldList $fields){
        if (!Permission::check('ADMIN')){
            $fields->removeByName('LinkTracking');
            $fields->removeByName('FileTracking');
        }
    }

}