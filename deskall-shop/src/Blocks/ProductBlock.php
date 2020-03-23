<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\FieldType\DBField;

class ProductBlock extends BaseElement implements Searchable{

	private static $menu_icon_class = '';
	
	private static $controller_template = 'BlockHolder';

	private static $controller_class = BlockController::class;
	
	private static $db = array(
		'Lead' => 'HTMLText',
	);


	public function getCMSFields()
	{
		$fields = parent::getCMSFields();



		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Lead', _t('TextBlock.Lead', 'Lead'))->setRows(10) );
		$this->extend('updateCMSFields', $fields);

		return $fields;
	}

    public function activeCategories(){
        return ProductCategory::get()->filter('isVisible',1);
    }


	 public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Produkte Block');
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

