<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;

class LayoutControllerExtension extends Extension
{
   
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
}