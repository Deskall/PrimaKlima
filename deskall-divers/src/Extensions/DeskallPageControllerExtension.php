<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;

class DeskallPageControllerExtension extends Extension
{
   
    public function IsLive() {
        return Director::isLive();
    }

    public function Css(){
    	$css_compiled = file_get_contents(Director::baseFolder().'/deskall-layout/templates/Includes/Css.ss');
        $css = new DBHTMLText();
        $css->setValue($css_compiled);
        return $css;
    }
}