<?php

use SilverStripe\ORM\DataObject;


class BoxCategory extends DataObject
{
    
    private static $has_one = [
        'Parent' => ProductCategoryBlock::class,
        'Category' => ProductCategory::class
    ];

}
