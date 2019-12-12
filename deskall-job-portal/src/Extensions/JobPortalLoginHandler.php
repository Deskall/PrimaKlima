<?php


use SilverStripe\Security\MemberAuthenticator\LoginHandler;
use SilverStripe\Security\Security;
use SilverStripe\Security\Group;

class JobPortalLoginHandler extends LoginHandler
{

    protected function redirectAfterSuccessfulLogin()
    {
    	$member = Security::getCurrentUser();
	    if ($member->inGroup('arbeitgeber')){
	    	$group = Group::get()->filter('Code','arbeitgeber')->first();
	    	$page = MemberProfilePage::get()->filter('GroupID',$group->ID)->first(); 
	        return $this->redirect($page->Link());
	    }
	    elseif ($member->inGroup('kandidaten')){
	    	$group = Group::get()->filter('Code','kandidaten')->first();
	    	$page = MemberProfilePage::get()->filter('GroupID',$group->ID)->first(); 
	        return $this->redirect($page->Link());
	    }
	    else{
	      if (!empty($data['BackURL'])) {
	         return $this->redirect($data['BackURL']);
	      }
	      return $this->redirect('/admin');
	    }
	    return false;
    }
}