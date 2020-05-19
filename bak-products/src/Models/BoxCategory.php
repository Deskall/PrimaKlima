<?php

namespace Bak\Products\Models;

use SilverStripe\ORM\DataObject;
use Bak\Products\Blocks\ProductCategoryBlock;
use Bak\Products\Models\ProductCategory;

class BoxCategory extends DataObject
{
    private static $table_name = 'BAK_BoxCategory';

    private static $has_one = [
        'Parent' => ProductCategoryBlock::class,
        'Category' => ProductCategory::class
    ];

    private static $extensions = [
        'Sortable',
        'Activable'
    ];

    public function getCMSFields(){
    	$fields = parent::getCMSFields();
    	$fields->removeByName('ParentID');

    	return $fields;
    }

}
