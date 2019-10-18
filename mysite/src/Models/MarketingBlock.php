<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;

class MarketingBlock extends TextBlock
{
    private static $icon = 'font-icon-tags';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Marketing Block";

    private static $db = [
        'Countdown' => 'DateTime',
        'LabelText' => 'Varchar',
        'LabelColor' => 'Varchar'
    ];

    private static $table_name = 'MarketingBlock';

    private static $singular_name = 'Marketing Block';

    private static $plural_name = 'Marketing Blöcke';

    private static $description = 'Marketing Block mit Bild, Text, Counter und Label';



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
        return _t(__CLASS__ . '.BlockType', 'Marketing Block mit Bild, Text, Counter und Label');
    }


}
