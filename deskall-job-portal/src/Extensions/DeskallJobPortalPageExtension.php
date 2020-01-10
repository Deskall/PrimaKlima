<?php

use SilverStripe\ORM\DataExtension;


class DeskallJobPortalPageExtension extends DataExtension
{
    public function RegisterPage($groupcode){
    	$group = Group::get()->filter('Code',$groupcode)->first();
    	if ($group){
    		return RegisterPage::get()->filter('GroupID',$group)->first();
    	}
        return null;
    }

    public function CurrentCustomer(){
    	
    	if ($this->owner->CurrentMember()){
    		return JobGiver::get()->filter('MemberID',$this->owner->CurrentMember()->ID)->first();
    	}
        return null;
    }

    public function getPortal(){
       return JobPortalConfig::get()->first();
    }

    public function OfferPage(){
        return OfferPage::get()->first();
    }
}