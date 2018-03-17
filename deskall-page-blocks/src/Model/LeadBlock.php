<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;

class LeadBlock extends BaseElement
{
    private static $icon = 'font-icon-menu';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'isPrimary' => 'Boolean(0)'
    ];

   
    private static $table_name = 'LeadBlock';

    private static $singular_name = 'lead block';

    private static $plural_name = 'lead blocks';

    private static $description = 'Highlight on HTML text';

    private static $cascade_duplicates = [];

    public function populateDefaults(){
        parent::populateDefaults();
        if ($this->isPrimary){
            $this->ShowTitle = 1;
        }
    }


    /**
     * Re-title the HTML field to Content
     *
     * {@inheritDoc}
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
                $fields->removeByName('isPrimary');
                if ($this->isPrimary){
                    $fields->removeByName('Title');
                }
        });
        return parent::getCMSFields();
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Lead');
    }

    public function canDelete($member = null){
        if ($this->isPrimary){
            return false;
        }
        return parent::canDelete();
    }

}
