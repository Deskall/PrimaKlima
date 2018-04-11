<?php

use SilverStripe\ORM\DataExtension;


class UserDefinedFormExtension extends DataExtension 
{

    public function updateForm(){
        $this->owner->setTemplate('Forms/MultiStepsForm_Vertical');
    }

    public function updateFormFields($fields){
    	
    	foreach ($fields as $fieldset) {
            if ($fieldset->Type() == "userformsstep"){
                $fieldset->setTemplate('Forms/EditableFormStepField_Vertical');
            }
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
            case "date-alt text":
                $field->setAttribute('class','uk-input flatpickr');
                $field->setInputType('text');
            break;
            default:
                $field->setAttribute('class','uk-input');
            break;
	    }

    }

    public function updateFormActions($actions){
    	foreach ($actions as $action){
    		$action->addExtraClass('uk-button');
            $action->addExtraClass('dk-button-icon')->setUseButtonTag(true)
            ->setAttribute('data-uk-icon','chevron-right');
    	}
    }

}