<?php

use SilverStripe\ORM\DataExtension;

class RenameFileExtension extends DataExtension
{

    public function onBeforeWrite(){
       
        $filename = pathinfo($this->owner->Filename);
        $filename = str_replace('.',"-",$filename);
        $this->Filename = $filename.$this->owner->getExtension();

        parent::onBeforeWrite();
    }

}