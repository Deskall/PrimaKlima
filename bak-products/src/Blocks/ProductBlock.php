<?php

namespace Bak\Products\Blocks;

use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\FieldType\DBField;


class ProductBlock extends BaseElement
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

    
    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

}
