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
        $css = new DBHTMLText();
        $css->setValue(htmlspecialchars_decode('<style>'.file_get_contents(Director::baseFolder().'/'.$this->owner->ThemeDir().'/css/main.min.css').'</style>'));
        return $css;
    }
}
