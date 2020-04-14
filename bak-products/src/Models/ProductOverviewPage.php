<?php

namespace Bak\Products\Models;

use Page;
use Bak\Products\Controllers\ProductOverviewPageController;
use SilverStripe\Security\Permission;


class ProductOverviewPage extends Page 
{
    public function isAdmin(){
        return Permission::check('ADMIN');
    }

    public function getControllerName()
    {
        return ProductOverviewPageController::class;
    }
}
  
