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
        $plz = $request->postVar('plz-choice');
        var_dump($plz);
        if ($plz){
            $PostalCode = PostalCode::get()->byCode($plz);
            if ($PostalCode){
                Cookie::set('yplay_plz', $PostalCode->ID);
                Session::set('active_plz',$PostalCode->ID);
            }

            return $this->owner->redirectBack();
            
        }
        return $this->owner->redirectBack();
    }

    public function activePLZ(){
        $plz = $this->owner->getRequest()->getSession()->get('active_plz');
        if ($plz){
            $PostalCode = PostalCode::get()->byId($plz);
            return $PostalCode;
        }
        return null;
    }
}