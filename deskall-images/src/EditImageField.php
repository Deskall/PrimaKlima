<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class EditImageField extends LiteralField{

	public function __construct($name, $title = null, $value = null)
    {
    	
        Requirements::css("deskall-images/css/toast-ui/tui-image-editor.min.css");
        Requirements::javascript("deskall-images/javascript/toast-ui/tui-image-editor.min.js");

        parent::__construct($name, $title, $value);
    }
 	

	

}