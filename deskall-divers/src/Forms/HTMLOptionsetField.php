<?php

use SilverStripe\Forms\OptionsetField;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Forms\FormField;
use SilverStripe\View\Requirements;

class HTMLOptionsetField extends OptionsetField{
	protected $template = 'Forms/HTMLOptionsetField';

	protected $extraClasses = ['optionset'];

	public function __construct($name, $title = null, $value = null)
    {
    	//Requirements::javascript("mysite/javascript/htmloptionset.js");
        Requirements::css("deskall-divers/css/htmloptionset.css");

        parent::__construct($name, $title, $value);
    }
 	
	
 	public function Field($properties = array()) {
		$options = array();
        $odd = false;

        // Add all options striped
        foreach ($this->getSourceEmpty() as $array) {
            $odd = !$odd;
            $options[] = $this->getHtmlFieldOption($array['value'], $array['icon'], $array['title'], $odd);
        }

        $properties = array_merge($properties, array(
            'Options' => new ArrayList($options)
        ));

		
		return FormField::Field($properties);
	}

	protected function getHtmlFieldOption($value, $icon, $title, $odd)
    {
        return new ArrayData(array(
            'ID' => $this->getOptionID($value),
            'Class' => $this->getOptionClass($value, $odd),
            'Name' => $this->getOptionName(),
            'Value' => $value,
            'Icon' => $icon,
            'Title' => $title,
            'isChecked' => $this->isSelectedValue($value, $this->Value()),
            'isDisabled' => $this->isDisabledValue($value)
        ));
    }
}