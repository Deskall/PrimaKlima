<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Security;

class DeskallJobPortalPageExtension extends DataExtension
{

    public function CurrentCandidat(){
        
        if (Security::getCurrentUser()){
            return Candidat::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
        }
        return null;
    }

    public function getPortal(){
       return JobPortalConfig::get()->first();
    }

    public function OfferPage(){
        return OfferPage::get()->first();
    }

    public function MemberPage(){
        return MemberProfilePage::get()->first();
    }
}