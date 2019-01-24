<?php


use SilverStripe\Forms\CheckboxField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableCheckbox;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\CMS\Model\SiteTree;

/**
 * EditableCheckbox
 *
 * A user modifiable checkbox on a UserDefinedForm
 *
 * @package userforms
 */

class EditableHTMLCheckbox extends EditableCheckbox
{
    private static $singular_name = 'Checkbox Field with HTML Label';

    private static $plural_name = 'Checkboxes';

    protected $jsEventHandler = 'click';

    private static $db = [
        'HTMLLabel' => 'HTMLText' // from CustomSettings
    ];

    private static $table_name = 'EditableHTMLCheckbox';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', HTMLEditorField::create(
            "HTMLLabel",
            _t('SilverStripe\\UserForms\\Model\\EditableFormField.HTMLLabel', 'Label (HTML)')
        ));

        return $fields;
    }

    public function getFormField()
    {
        $title = DBHTMLText::create();
        $title->setValue(SiteTree::link_shortcode_handler($this->HTMLLabel));
        $field = CheckboxField::create($this->Name, $title ?: false, $this->CheckedDefault)
            ->setFieldHolderTemplate(__CLASS__ . '_holder')
            ->setTemplate(__CLASS__);

        $this->doUpdateFormField($field);

        return $field;
    }

    public function getValueFromData($data)
    {
        $value = (isset($data[$this->Name])) ? $data[$this->Name] : false;

        return ($value)
            ? _t('SilverStripe\\UserForms\\Model\\EditableFormField.YES', 'Yes')
            : _t('SilverStripe\\UserForms\\Model\\EditableFormField.NO', 'No');
    }

    public function isCheckBoxField()
    {
        return true;
    }
}
