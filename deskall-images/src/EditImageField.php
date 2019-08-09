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
    	
        Requirements::css("deskall-images/css/tui-image-editor.css");
        Requirements::javascript("deskall-images/javascript/tui-image-editor.js");

        ob_start();
        			print_r('ici');
        			$result = ob_get_clean();
        			file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);

        parent::__construct($name, $title, $value);
    }
 	

	

}