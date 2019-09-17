<?php


use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableCheckbox;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Parsers\ShortcodeParser;
/**
 * EditableCheckbox
 *
 * A user modifiable checkbox on a UserDefinedForm
 *
 * @package userforms
 */

class EditableNewsletterCheckbox extends EditableHTMLCheckbox
{
    private static $singular_name = 'Newsletter Checkbox';

    private static $plural_name = 'Newsletter Checkboxes';

    protected $jsEventHandler = 'click';

    private static $db = [
        'HTMLLabel' => 'HTMLText',
        'MailChimpID' => 'Varchar',
        'ListeID' => 'Varchar'
    ];

    private static $table_name = 'EditableNewsletterCheckbox';

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

        $fields->addFieldToTab('Root.Main', TextField::create(
            "MailChimpID",
            _t('FormField.MailChimpID', 'Mailchimp API Key')
        ));

        $fields->addFieldToTab('Root.Main', TextField::create(
            "ListeID",
            _t('FormField.ListeID', 'Empfängerliste ID')
        ));

        return $fields;
    }

    public function getFormField()
    {
        $title = DBHTMLText::create();
        $title->setValue(ShortcodeParser::get_active()->parse($this->HTMLLabel));
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
            ? _t('SilverStripe\\UserForms\\Model\\EditableFormField.YES', 'Ja')
            : _t('SilverStripe\\UserForms\\Model\\EditableFormField.NO', 'Nein');
    }

    public function isCheckBoxField()
    {
        return true;
    }

    /**
     * Validates the captcha against the Recaptcha2 API
     * @param Validator $validator Validator to send errors to
     * @return bool Returns boolean true if valid false if not
     */
    public function validate() {
        ob_start();
                    print_r($this->Name);
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        if(isset($_REQUEST[$this->Name])) {
            
        }
        
        
        
        return true;
    }
}
