<?php

namespace Bak\Products\Blocks;

use TextBlock;
use Bak\Products\Models\ProductUseArea;
use Bak\Products\Models\ProductCategory;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class ProductCategoryBlock extends TextBlock
{
    private static $icon = 'font-icon-block-content';

    private static $help_text = "Kategorie Boxen";

    private static $table_name = 'BAK_ProductCategoryBlock';

    private static $singular_name = 'Kategorie Boxen';

    private static $plural_name = 'Kategorie Boxen';

    private static $description = 'Kategorie Boxen';

    private static $has_many = [
        'Boxes' => BoxCategory::class
    ];

    private static $owns = [
        'Boxes',
    ];

    private static $cascade_deletes = [
        'Boxes',
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Boxes');
        $config = GridFieldConfig_RecordEditor::create();
        $config->addComponent(new GridFieldOrderableRows('Sort'));
        if (singleton('Box')->hasExtension('Activable')){
             $config->addComponent(new GridFieldShowHideAction());
        }
        $boxesField = new GridField('Boxes',_t(__CLASS__.'.Boxes','Boxen'),$this->Boxes(),$config);
        $fields->addFieldToTab('Root.Main',$boxesField);
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Kategorie Boxen');
    }

}
