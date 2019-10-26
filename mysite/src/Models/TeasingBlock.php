<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class TeasingBlock extends TextBlock
{
    private static $icon = 'font-icon-tags';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Teasing Block";

    private static $db = [
        
    ];

    private static $table_name = 'TeasingBlock';

    private static $singular_name = 'Teasing Block';

    private static $plural_name = 'Teasing Blöcke';

    private static $description = 'Teasing Block mit Bild, Text, Grafik und Label';



    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Teasing Block');
    }
}
