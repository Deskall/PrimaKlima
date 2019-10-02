<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;

class DeskallPageControllerExtension extends Extension
{
   
    public function IsLive() {
        return Director::isLive();
    }

    public function Css(){
    	$css_compiled = file_get_contents(Director::baseFolder().SiteConfig::current_site_config()->getCurrentThemeDir().'/templates/Includes/Css.ss');
        $css = new DBHTMLText();
        $css->setValue($css_compiled);
        return $css;
    }
}