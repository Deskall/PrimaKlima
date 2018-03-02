<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;

class IconDropdownField extends DropdownField{
	protected $template = 'Forms/IconDropdownField';

	private static $default_classes = ['dropdown'];

	public function __construct($name, $title = null, $value = null)
    {
    	Requirements::javascript("mysite/js/icondropdown.js");
        Requirements::css("mysite/css/icondropdown.css");

        parent::__construct($name, $title, $value);
    }
 
}