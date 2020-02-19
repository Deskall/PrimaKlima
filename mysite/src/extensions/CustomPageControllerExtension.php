<?php
use SilverStripe\Core\Extension;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Control\Cookie;
use SilverStripe\Control\Session;
use SilverStripe\Control\HTTPRequest;

class CustomPageControllerExtension extends Extension
{   

	public function Css(){

	 	if (SubsiteState::singleton()->getSubsiteId() > 0){
            $subsite = Subsite::get()->byId(SubsiteState::singleton()->getSubsiteId());
	 		$css_compiled = file_get_contents(Director::baseFolder().'/themes/'.$subsite->Theme.'/templates/Includes/Css.ss');
	 	}
    	else{
    		$css_compiled = file_get_contents(Director::baseFolder().'/themes/yplay/templates/Includes/Css.ss');
    	}
        $css = new DBHTMLText();
        $css->setValue($css_compiled);
        return $css;
    }

    public function loggedIn(){
        return Security::getCurrentUser();
    }

    public function getSessionData($key,$clear = false){
        $session = $this->owner->getRequest()->getSession();
        $data = $session->get($key);
        if ($clear){
            $session->clear($key);
        }
        return $data;
    }

}