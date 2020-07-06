<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class CustomerMoveBlock extends TextBlock
{
    private static $icon = 'font-icon-switch';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = CustomerMoveBlockController::class;

    private static $help_text = "Kunden Umzug Block";

    private static $table_name = 'CustomerMoveBlock';

    private static $singular_name = 'Kunden Umzug Block';

    private static $plural_name = 'Kunden Umzug Blöcke';

    private static $description = 'Kunden Umzug';


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Kunden Umzug: Partner Wahl nach PLZ');
    }
}
