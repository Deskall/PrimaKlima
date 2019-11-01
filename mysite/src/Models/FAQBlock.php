<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\SiteConfig\SiteConfig;

class FAQBlock extends TextBlock
{
    private static $icon = 'font-icon-help-circled';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "FAQ Block";

    private static $table_name = 'FAQBlock';

    private static $singular_name = 'FAQ Block';

    private static $plural_name = 'FAQ Blöcke';

    private static $description = 'Häufigen Fragen, als Icon oder nach Kategorien';

    private static $has_one = ['Category' => FAQCategory::class];

    private static $many_many = ['Items' => FAQItem::class]

    public function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
        $labels['Category'] = 'Kategorie';
        $labels['Items'] = 'Fragen';
        
        return $labels;
    }

        
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
        return _t(__CLASS__ . '.BlockType', 'Häufigen Fragen, als Icon oder nach Kategorien');
    }
}
