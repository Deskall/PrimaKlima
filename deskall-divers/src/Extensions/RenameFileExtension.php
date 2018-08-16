<?php

use SilverStripe\ORM\DataExtension;

class RenameFileExtension extends DataExtension
{

    public function onAfterUpload(){
       
        $filename = pathinfo($this->owner->Filename,PATHINFO_FILENAME);
        $ext = pathinfo($this->owner->Filename,PATHINFO_EXTENSION);
        $filename = str_replace('.',"-",$filename);
        $this->owner->Filename = $filename.".".$ext;
        $this->owner->write();
        
    }

}