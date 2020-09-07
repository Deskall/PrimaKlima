<?php


use DNADesign\Elemental\Models\ElementalArea;
use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\EmailField;
use UndefinedOffset\NoCaptcha\Forms\NocaptchaField;

class OverlayContentControllerExtension extends Extension
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'handleElement',
        'NewsletterForm'
    );

    public function handleElement()
    {
        $id = $this->owner->getRequest()->param('ID');

        if (!$id) {
            user_error('No element ID supplied', E_USER_ERROR);
            return false;
        }

        /** @var SiteTree $elementOwner */
        $elementOwner = $this->owner->data();

        $elementalAreaRelations = $this->owner->getElementalRelations();

        if (!$elementalAreaRelations) {
            user_error(get_class($this->owner) . ' has no ElementalArea relationships', E_USER_ERROR);
            return false;
        }

        foreach ($elementalAreaRelations as $elementalAreaRelation) {
            $element = $elementOwner->$elementalAreaRelation()->Elements()
                ->filter('ID', $id)
                ->First();

            if ($element) {
                return $element->getController();
            }
        }

        //Overlays
        if ($elementOwner->Overlay()->exists()){
            $element = $elementOwner->Overlay()->FormBlock();
            if ($element) {
                return $element->getController();
            }
        }

        user_error('Element $id not found for this page', E_USER_ERROR);
        return false;
    }

    public function NewsletterForm(){
        $fields = new FieldList(
            EmailField::create('Email', 'Ihre E-Mail-Adresse'),
            NocaptchaField::create('Captcha')
        );

        $actions = new FieldList(
            FormAction::create('registerToNewsletter')->setTitle($this->owner->Overlay()->ValidButtonText)
        );

        $required = new RequiredFields(['Email','Captcha']);

        $form = new Form($this->owner, 'NewsletterForm', $fields, $actions, $required);

        return $form;
    }

    public function registerToNewsletter($data, Form $form){
        $form->sessionMessage('Email ' . $data['Email'] . 'registriert!', 'success');

        return $this->redirectBack();
    }
}
