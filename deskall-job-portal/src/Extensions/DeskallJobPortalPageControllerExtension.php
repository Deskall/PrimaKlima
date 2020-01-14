<?php

use SilverStripe\ORM\DataExtension;


class DeskallJobPortalPageControllerExtension extends DataExtension
{
   

    public function getPortal(){
       return JobPortalConfig::get()->first();
    }

    public function TestExtension(){
        return 'OK';
    }

  
}