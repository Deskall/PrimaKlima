<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class MemberExtension extends DataExtension
{

    

    /** create all deskall accounts on dev/build **/
    public function requireDefaultRecords()
    {
        //Groupd and admin already created
        parent::requireDefaultRecords();
        
    }
}