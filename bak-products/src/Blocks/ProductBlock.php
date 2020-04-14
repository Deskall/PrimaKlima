<?php

namespace Bak\Products\Blocks;

use TextBlock;
use Bak\Products\Models\ProductUseArea;
use Bak\Products\Models\ProductCategory;


class ProductBlock extends TextBlock
{
    private static $icon = 'font-icon-block-content';

    private static $help_text = "Produkte Block";

    private static $table_name = 'BAK_ProductBlock';

    private static $singular_name = 'Produkt Block';

    private static $plural_name = 'Produkt Blöcke';

    private static $description = 'Produkte Übersicht';

    private static $db = ['test' => 'Varchar'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'BAK Produkte Übersicht');
    }


    public function getCategories(){
        return ProductCategory::get();
    }

    public function getUseArea(){
        return ProductUseArea::get();
    }

}
