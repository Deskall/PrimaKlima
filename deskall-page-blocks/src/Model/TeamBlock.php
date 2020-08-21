<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class TeamBlock extends BaseElement implements Searchable
{
    private static $inline_editable = false;
    
    private static $icon = 'font-icon-torsos-all';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $help_text = "Team Block";

	private static $has_many = array(
		'Boxes' => TeamBox::class
	);


	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		if( $this->ID > 0){
	        $BoxesField = new GridField(
	            'Boxes',
	            'Teammitglieder',
	            $this->Boxes(),
	            GridFieldConfig_RecordEditor::create()
	        );

	        $fields->addFieldToTab('Root.Main', $BoxesField);
		}

		$this->extend('updateCMSFields', $fields);
		return $fields;
	}


	public function getType()
	{
	    return _t(__CLASS__ . '.BlockType', 'Team Block');
	}

	/************* SEARCHABLE FUNCTIONS ******************/
		public function getBoxesHTML(){
			$html = '';
			if ($this->Boxes()->filter('isVisible',1)->count() > 0){
			    $html .= '<ul>';
			    foreach ($this->Boxes()->filter('isVisible',1) as $item) {
			        $html .= '<li>';
			        if ($item->Title){
			            $html .= $item->Title."\n";
			        }
			        if ($item->Function){
			            $html .= $item->Function."\n";
			        }
			        if ($item->Email){
			            $html .= $item->Email."\n";
			        }
			        if ($item->Telephone){
			            $html .= $item->Telephone;
			        }
			        if ($item->Content){
			            $html .= $item->Content;
			        }
			        $html .= '</li>';
			    }
			    $html .='</ul>';
			}
			return $html;
		}

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
	        return array('BoxesHTML');
	    }
	/************ END SEARCHABLE ***************************/

}


