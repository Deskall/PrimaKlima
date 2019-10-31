<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class ProductBlock extends TextBlock
{
    private static $icon = 'font-icon-tags';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Produkte Block";

    private static $db = [
        
    ];

    private static $has_one = ['Category' => ProductCategory::Class];

    private static $many_many = ['Products' => Product::class];

    private static $table_name = 'ProductBlock';

    private static $singular_name = 'Produkt Block';

    private static $plural_name = 'Produkt Blöcke';

    private static $description = 'Zeigt Produktdetails nach Kategorie oder custom Wahl an';


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Zeigt Produktdetails nach Kategorie an');
    }
}
