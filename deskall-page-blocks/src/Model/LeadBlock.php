<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Security\Permission;
use g4b0\SearchableDataObjects\Searchable;

class LeadBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-menu';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText'
    ];

   
    private static $table_name = 'LeadBlock';

    private static $singular_name = 'lead block';

    private static $plural_name = 'lead blocks';

    private static $description = 'Highlight on HTML text';

    private static $cascade_duplicates = [];

    private static $extensions = [
        'CollapsableTextExtension'
    ];

    public function canDesactivate(){
        if ($this->isPrimary){
            return false;
        }
        return parent::canDesactivate();
    }


    /**
     * Re-title the HTML field to Content
     *
     * {@inheritDoc}
     */
    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('Layout');
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'))
                ->setRows(8);
                // $fields->removeByName('isPrimary');
                if ($this->isPrimary){
                   $fields->removeByName('TitleAndDisplayed');
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
        if ($this->isPrimary && !Permission::check('ADMIN')){
            return false;
        }
        return parent::canDelete();
    }

    /************* SEARCHABLE FUNCTIONS ******************/


        /**
         * Filter array
         * eg. array('Disabled' => 0);
         * @return array
         */
        public static function getSearchFilter() {
            return array();
        }

        /**
         * FilterAny array (optional)
         * eg. array('Disabled' => 0, 'Override' => 1);
         * @return array
         */
        public static function getSearchFilterAny() {
            return array();
        }


        /**
         * Fields that compose the Title
         * eg. array('Title', 'Subtitle');
         * @return array
         */
        public function getTitleFields() {
            return array('Title');
        }

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML');
        }

    /************ END SEARCHABLE ***************************/

}
