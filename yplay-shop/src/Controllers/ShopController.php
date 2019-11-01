<?php

use DNADesign\Elemental\Controllers\ElementController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\i18n\i18n;
use SilverStripe\Security\Member;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ArrayList;

class ShopController extends PageController
{

   private static $allowed_actions = ['fetchPackages']; 

   public function fetchPackages(){
   	return json_encode(new ArrayList(Package::get()));
   } 
}