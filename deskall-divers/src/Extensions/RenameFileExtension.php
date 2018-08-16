<?php

use SilverStripe\ORM\DataExtension;

class RenameFileExtension extends DataExtension
{

    public function onBeforeWrite(){
       
        $name = str_replace('.',"-",$this->owner->Name);
        $this->owner->Name = $name;
        parent::onBeforeWrite();
        
    }

}