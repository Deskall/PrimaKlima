<?php

use SilverStripe\ORM\DataExtension;


class GastroPortalPageExtension extends DataExtension
{
     public function getPortal(){
        return JobPortalConfig::get()->first();
     }
}