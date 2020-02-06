<?php


use SilverStripe\Core\Extension;
use SilverStripe\Core\Config\Config;

class DeskallCommentingControllerExtension extends Extension
{
	public function alterCommentForm($form)
	{
	    $fields = $form->Fields();

	    foreach ($fields as $fieldset) {
	    	if ($fieldset->Type() == "composite"){
	    		foreach ($fieldset->getChildren() as $field) {
		    		$this->setUiKitAttributes($field);
		    	}
	    	}
	    }
	   
	}

	public function setUiKitAttributes($field){
    	switch($field->Type()){
    		case "text":
    		case "email text":
    			$field->setAttribute('class','uk-input');
    			break;
    		case "dropdown":
    			$field->setAttribute('class','uk-select');
    			break;
    		case "textarea":
    			$field->setAttribute('class','uk-textarea');
    			break;
    		case "checkbox":
    			$field->setAttribute('class','uk-checkbox');
    			break;
    		case "userformsgroup":
				foreach ($field->getChildren() as $child) {
	    			$this->setUiKitAttributes($child);
	    		}
	    	break;
            case "date-alt text":
                $field->setAttribute('class','uk-input flatpickr');
                $field->setInputType('text');
            break;
            default:
                $field->setAttribute('class','uk-input');
            break;
	    }


    }

}
