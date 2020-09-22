<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;

class DeskallPageControllerExtension extends Extension
{
    public function IsLive() {
        return Director::isLive();
    }
}