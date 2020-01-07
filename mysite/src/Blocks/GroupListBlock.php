<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Control\Director;
use SilverStripe\Forms\TextField;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;

class GroupListBlock extends BaseElement implements Searchable
{
    private static $icon = 'font-icon-block-content';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Kurse List";

    private static $table_name = 'GroupListBlock';

    private static $singular_name = 'Kurse List Block';

    private static $plural_name = 'Kurse List Blöcke';

    private static $description = 'Kurse List';

    public function getCMSFields(){
        $fields = parent::getCMSFields();
      
      
        return $fields;
    }
   

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Kurse List');
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
            return array('Title');
        }
    /************ END SEARCHABLE ***************************/
}
