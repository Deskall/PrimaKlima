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
    private static $allowed_actions = ['SavePLZ'];

    private static $url_handlers = [
        'plz-speichern' => 'SavePLZ'
    ];

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

    public function SavePLZ(HTTPRequest $request){
        $this->owner->getRequest()->getSession()->clear('active_plz');
        
        $plz = $request->postVar('plz-choice');
        if ($plz){
            $PostalCode = PostalCode::get()->filter('Code',$plz)->first();
            if ($PostalCode){ 
                
                //if subsite we redirect
                if ($PostalCode->SubsiteID > 0){
                    return $this->owner->redirect($PostalCode->Link());
                }
                Cookie::set('yplay_plz', $PostalCode->ID);
                return $this->owner->redirectBack();
            }
            else{
                //return to unbekannt plz page
                return ['Title' => 'Unbekannt Region'];
            }
        }
        //should not happen as plz is mandatory, but redirecting anyway
        return $this->owner->redirectBack();
    }

    public function activePLZ(){
        //first we check if there is cookie
        $plz = Cookie::get('yplay_plz');
        // $plz = $this->owner->getRequest()->getSession()->get('active_plz');
        if ($plz){
            $PostalCode = PostalCode::get()->byId($plz);
            if ($PostalCode){
                if (!$this->owner->getRequest()->getSession()->get('active_plz')){
                   $this->owner->getRequest()->getSession()->set('active_plz',$PostalCode->ID); 
                }
                return $PostalCode;
            }
        }
        return null;
    }

    public function showModalPLZ(){
       if (!$this->owner->getRequest()->getSession()->get('active_plz_asked')){
         $this->owner->getRequest()->getSession()->set('active_plz_asked',true);
         return true;
       } 
       return false;
    }
}