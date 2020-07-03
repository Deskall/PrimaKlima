<?php

use SilverStripe\UserForms\Model\EditableFormField\EditableEmailField;
use SilverStripe\View\Requirements;
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
}
