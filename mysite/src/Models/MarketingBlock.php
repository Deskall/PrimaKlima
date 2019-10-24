<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class MarketingBlock extends TextBlock
{
    private static $icon = 'font-icon-tags';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Marketing Block";

    private static $db = [
        'Start' => 'DBDatetime',
        'Countdown' => 'DBDatetime',
        'LabelText' => 'Varchar',
        'Color' => 'Varchar'
    ];

    private static $table_name = 'MarketingBlock';

    private static $singular_name = 'Marketing Block';

    private static $plural_name = 'Marketing Blöcke';

    private static $description = 'Marketing Block mit Bild, Text, Counter und Label';



    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Color');
        $fields->insertAfter('isPrimary',HTMLDropdownField::create('Color',_t(__CLASS__.'.Color','Farbe'),SiteConfig::current_site_config()->getBackgroundColors())->setDescription(_t(__CLASS__.'.BackgroundColorHelpText','wird als overlay anzeigen falls es ein Hintergrundbild gibt.'))->addExtraClass('colors'));

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Marketing Block mit Bild, Text, Counter und Label');
    }
}
