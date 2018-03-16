<?php
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\DataExtension;

class DeskallTranslatable extends DataExtension
{

   public function getTranslatedSourceFor($class,$static){
        $source = [];
        foreach(Config::inst()->get($class,$static) as $key => $value){
            $source[$key] = _t($class.".".$static."_{$key}", $value);
        }
        return $source;
    }
}