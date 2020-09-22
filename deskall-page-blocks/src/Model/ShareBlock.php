<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;

class ShareBlock extends BaseElement
{
    private static $inline_editable = false;
    
    private static $icon = 'font-icon-external-link';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'ShowFacebook' => 'Boolean(0)',
        'ShowTwitter' => 'Boolean(0)',
        'ShowGoogle' => 'Boolean(0)',
        'ShowPinterest' => 'Boolean(0)',
        'ShowLinkedin' => 'Boolean(0)',
        'ShowXing' => 'Boolean(0)',
    ];

  

   
    private static $table_name = 'ShareBlock';

    private static $singular_name = 'Share Block';

    private static $plural_name = 'Share Blöcke';

    private static $description = 'Teilen Sie diese Seite in sozialen Netzwerken';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'))
                ->setRows(5);
        });
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Share Block');
    }

}
