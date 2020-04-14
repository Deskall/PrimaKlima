<?php

namespace Bak\Products\Blocks;

use TextBlock;



class ProductBlock extends TextBlock
{
    private static $icon = 'font-icon-block-content';

    private static $help_text = "Produkte Block";

    private static $table_name = 'BAK_ProductBlock';

    private static $singular_name = 'Produkt Block';

    private static $plural_name = 'Produkt Blöcke';

    private static $description = 'Produkte Übersicht';



    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'BAK Produkte Übersicht');
    }

}
