<?php

use SilverStripe\ORM\DataExtension;

class RenameFileExtension extends DataExtension
{

    public function onBeforeWrite(){
       
        // $name = pathinfo($this->owner->Name,PATHINFO_FILENAME);
        // $ext = pathinfo($this->owner->Name,PATHINFO_EXTENSION);
        // $name = str_replace('.',"-",$name);
        // $this->owner->Name = $name.".".$ext;
        parent::onBeforeWrite();
        
    }

}