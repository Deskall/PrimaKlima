<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Convert;
use SilverStripe\View\ArrayData;

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

    public function ThemeDir(){
        return SiteConfig::current_site_config()->getCurrentThemeDir();
    }

    public function LastChangeJS(){
        $srcDir = Director::baseFolder().SiteConfig::current_site_config()->getCurrentThemeDir().'/javascript/vendor';
        $srcFiles = array_diff(scandir($srcDir), array('.', '..'));
        $filetime = 0;
        foreach($srcFiles as $key => $file) {
            if( filemtime($srcDir."/".$file) > $filetime)
            {
                $filetime = filemtime($srcDir."/".$file);
            }
        }
        return $filetime;
    }
}