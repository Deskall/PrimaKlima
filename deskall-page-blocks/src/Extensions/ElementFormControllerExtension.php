<?php

use DNADesign\ElementalUserForms\Control\ElementFormController;
use SilverStripe\Control\Director;

class ElementFormControllerExtension extends ElementFormController
{

	 private static $allowed_actions = [
        'finished'
    ];

	public function finished()
    {
    	if ($this->element->RedirectPageID > 0){
    		$redirectPage = DataObject::get_by_id('SiteTree',$this->element->RedirectPageID);
    		if ($redirectPage){
    			return $this->redirect($redirectPage->Link());
    		}
    	}
    	
    	parent::finished();
        
    }

}