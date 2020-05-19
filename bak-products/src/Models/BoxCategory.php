<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use Bak\Products\Blocks\ProductCategoryBlock;
use Bak\Products\Models\ProductCategory;

class BoxCategory extends DataObject
{
    
    private static $has_one = [
        'Parent' => ProductCategoryBlock::class,
        'Category' => ProductCategory::class
    ];

}
