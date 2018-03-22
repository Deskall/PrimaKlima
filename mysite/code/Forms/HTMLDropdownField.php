<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Forms\FormField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class HTMLDropdownField extends DropdownField{
	protected $template = 'Forms/HTMLDropdownField';

	protected $extraClasses = [];

	private static $iconsList = [
		'chevron-right' => 'chevron-right',
		'home' => 'home',
		'mail' => 'Email',
		'receiver' => 'Telefon',
		'location' => 'Marker',
		'user' => 'Person',
		'users' => 'Personen',
		'tag' => 'Tag',
		'calendar' => 'Kalender',
		'search' => 'Suche',
		'list' => 'Liste',
		'lock' => 'Private',
		'facebook' => 'facebook',
		'twitter' => 'twitter',
		'google-plus' => 'google-plus',
		'linkedin' => 'linkedin',
		'xing' => 'xing'
	];

	public function __construct($name, $title = null, $value = null)
    {
    	Requirements::javascript("mysite/javascript/htmldropdown.js");
        Requirements::css("mysite/css/htmldropdown.css");
        Requirements::css("mysite/javascript/uikit-icons.js");

        parent::__construct($name, $title, $value);
    }
 	

 	public function Field($properties = array()) {
		$source = $this->getSource();
		$options = array();
        
        if ($this->getHasEmptyDefault()) {
			$selected = ($this->value === '' || $this->value === null);
			$disabled = (in_array('', $this->disabledItems, true)) ? 'disabled' : false;
			$empty = $this->getEmptyString();
			
			$options[] = new ArrayData(array(
				'Value' => '',
				'Title' => $empty,
				'Selected' => $selected,
				'Disabled' => $disabled,
				'HTML' => $empty,
				'Attributes' => $this->createOptionAttributes($empty)
			));
		}
        
		if($source) {
			foreach($source as $value => $params) {
				$selected = false;
				if($value === '' && ($this->value === '' || $this->value === null)) {
					$selected = true;
				} else {
					// check against value, fallback to a type check comparison when !value
					if($value) {
						$selected = ($value == $this->value);
					} else {
						$selected = ($value === $this->value) || (((string) $value) === ((string) $this->value));
					}
					$this->isSelected = $selected;
				}
				
				$disabled = false;
				if(in_array($value, $this->disabledItems) && $params['Title'] != $this->emptyString ){
					$disabled = 'disabled';
				}
				$html = new DBHTMLText();
				$html->setValue($params['HTML']);
				$options[] = new ArrayData(array(
					'Title' => $params['Title'],
					'Value' => $value,
					'Selected' => $selected,
					'Disabled' => $disabled,
					'HTML' => $html ,
					'Attributes' => $this->createOptionAttributes($params)
				));
			}
		}
		$properties = array_merge($properties, array('Options' => new ArrayList($options)));
		return FormField::Field($properties);
	}
	public function createOptionAttributes($params) {
		$attributes = new ArrayList();
		if(isset($params['Attributes'])) {
			if($params['Attributes'] instanceOf ArrayList) {
				$attributes = $params['Attributes'];
			} else {
				foreach($params['Attributes'] as $k => $v) {
					$attributes->push(new ArrayData(array(
						'Name' => $k,
						'Value' => $v
					)));
				}
			}
		}
		return $attributes;
	}

	public static function getSourceIcones(){
		$source = [];
		$iconsList = Config::inst()->get(__CLASS__,'iconsList');
      

        foreach($iconsList as $icon => $name){
            $html = '<div class="option-html">
        			<span uk-icon="icon: '.$icon.'"></span>'.$name.'
      			</div>';
       
            $source[$icon] = [
                'Title' => $name,
                'HTML' => $html
                
            ];
        }

		return $source;
	}
}