<?php

use SilverStripe\ORM\DataExtension;


class UserDefinedFormExtension extends DataExtension 
{
    public function updateFormFields($fields){
    	
    	foreach ($fields as $fieldset) {
    		foreach ($fieldset->getChildren() as $field) {
    			$this->setUiKitAttributes($field);
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
	    }

    }

    public function updateFormActions($actions){
    	foreach ($actions as $action){
    		$action->addExtraClass('uk-button uk-button-primary');
            if ($this->owner->controller->record['hasCaptcha']){
                $action->addExtraClass('g-recaptcha')->setAttribute('data-sitekey','123456')->setAttribute('data-callback','onSubmit');
            }
    	}
    }

}