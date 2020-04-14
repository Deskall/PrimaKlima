<?php

namespace Bak\Products\Models;

use Page;

use SilverStripe\Security\Permission;


class ProductOverviewPage extends Page 
{
    public function isAdmin(){
        return Permission::check('ADMIN');
    }
}
  
