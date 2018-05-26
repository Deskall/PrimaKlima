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
    	$css_compiled = file_get_contents(Director::baseFolder().'/'.$this->owner->ThemeDir().'/css/main.min.css');
    	//$css_compiled = str_replace("url('../fonts","url('".$this->owner->ThemeDir()."/fonts",$css_compiled);
        $css = new DBHTMLText();
        $css->setValue(htmlspecialchars_decode('<style>'.$css_compiled.'</style>'));
        return $css;
    }
}
