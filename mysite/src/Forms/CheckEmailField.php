<?php

use SilverStripe\Forms\EmailField;
use SilverStripe\View\Requirements;
/**
 * Second Email input field with validation based on first Email field.
 */
class CheckEmailField extends EmailField
{

    protected $inputType = 'email';
    /**
     * {@inheritdoc}
     */
    public function Type()
    {
        return 'email text';
    }

    private static $has_one = [
        'Referent' => EmailField::class
    ];

    public function Field($properties=array()) {

        Requirements::javascript('mysite/javascript/CheckEmailField.js');
        
        // Requirements::customScript(
        //     "(function() {\n" .
        //         "var gr = document.createElement('script'); gr.type = 'text/javascript'; gr.async = true;\n" .
        //         "gr.src = ('https:' == document.location.protocol ? 'https://www' : 'http://www') + " .
        //         "'.google.com/recaptcha/api.js?render=explicit&hl=" .
        //         Locale::getPrimaryLanguage(i18n::get_locale()) .
        //         "&onload=noCaptchaFieldRender';\n" .
        //         "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(gr, s);\n" .
        //     "})();\n",
        //     'NocaptchaField-lib'
        // );

        return parent::Field($properties);
    }
}
