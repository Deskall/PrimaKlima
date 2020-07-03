<?php

use SilverStripe\UserForms\Model\EditableFormField\EditableEmailField;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\UserForms\Model\EditableFormField;

/**
 * Second Email input field with validation based on first Email field.
 */
class EditableCheckEmailField extends EditableEmailField
{

    private static $singular_name = 'Check Email Field';

    private static $plural_name = 'Check Email Fields';

    private static $has_placeholder = true;

    private static $table_name = 'EditableCheckEmailField';

    private static $has_one = [
        'Referent' => EditableEmailField::class
    ];

    public function getCMSFields(){
        $fields = parent::getCMSFields();
        $referents = $this->Parent()->Fields()->filter('ClassName',EditableEmailField::class);
        if ($referents){
            $fields->insertAfter('Title',DropdownField::create('Referent','Referenz',$referents->map('ID','Title'))->setEmptyString('Bitte E-Mail Feld auswählen'));
        }
        
        return $fields;
    }

    public function getSetsOwnError()
    {
        return true;
    }

    public function getFormField()
    {
        Requirements::javascript('mysite/javascript/CheckEmailField.js');
        $field = EmailField::create($this->Name, $this->Title ?: false, $this->Default)
            ->setFieldHolderTemplate(EditableFormField::class . '_holder')
            ->setTemplate(EditableFormField::class);

        $this->doUpdateFormField($field);

        return $field;
    }

    /**
     * Updates a formfield with the additional metadata specified by this field
     *
     * @param FormField $field
     */
    protected function updateFormField($field)
    {
        parent::updateFormField($field);

        $field->setAttribute('data-rule-email', true);
    }

    public function validateField($data, $form)
    {
        $formField = $this->getFormField();
        $formField->setForm($form);

        if (isset($data[$this->Name])) {
            $formField->setValue($data[$this->Name]);
        }

        $validator = $form->getValidator();
        if (!$formField->validate($validator)) {
            $errors = $validator->getErrors();
            $foundError = false;

            // field validate implementation may not add error to validator
            if (count($errors) > 0) {
                // check if error already added from fields' validate method
                foreach ($errors as $error) {
                    if ($error['fieldName'] == $this->Name) {
                        $foundError = $error;
                        break;
                    }
                }
            }

            if ($foundError !== false) {
                // use error messaging already set from validate method
                $form->sessionMessage($foundError['message'], $foundError['messageType']);
            } else {
                // fallback to custom message set in CMS or default message if none set
                $form->sessionError($this->getErrorMessage()->HTML());
            }
        }
    }
}
