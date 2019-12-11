<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;

class DeskallPageControllerExtension extends Extension
{
   
    public function IsLive() {
        return Director::isLive();
    }

    public function HeadCss(){
    	$css_compiled = file_get_contents(Director::baseFolder().SiteConfig::current_site_config()->getCurrentThemeDir().'/templates/Includes/HeadCss.ss');
        $css = new DBHTMLText();
        $css->setValue($css_compiled);
        return $css;
    }

    public function BodyCss(){
    	$css_compiled = file_get_contents(Director::baseFolder().SiteConfig::current_site_config()->getCurrentThemeDir().'/templates/Includes/BodyCss.ss');
        $css = new DBHTMLText();
        $css->setValue($css_compiled);
        return $css;
    }

    public function CurrentUser(){
        return Security::getCurrentUser();
    }
}