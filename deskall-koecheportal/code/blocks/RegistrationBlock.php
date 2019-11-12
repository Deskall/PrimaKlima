<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBField;

class RegistrationBlock extends BaseElement implements Searchable{
	private static $menu_icon = 'deskall-koecheportal/images/icon-employer.png';
	
	private static $controller_template = 'BlockHolder';

	private static $controller_class = BlockController::class;
	
	private static $db = array(
		'MemberType' => 'Int',
		'Content'	 => 'HTMLText'
	);

	public function getCMSFields()	{
		$fields = parent::getCMSFields();

    	$fields->addFieldToTab('Root.Main',  DropdownField::create('MemberType', 'Registration für', array(
    		4 => 'Köche',
    		5 => 'Arbeitgeber',

    	))->setEmptyString('Köche & Arbeitgeber') );

       	$fields->addFieldToTab('Root.Main',  HTMLEditorField::create('Content', 'Beschreibung'));
		
		$this->extend('updateCMSFields', $fields);
		return $fields;
	}


	public function GetForm(){
		$page = new AccountPage_Controller();

		$form = $page->RegistrationForm( $this->MemberType );
		$form->setFormAction('/mein-koecheportal/RegistrationForm');

		return $form;
	}

	 public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Registrierung Block');
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
