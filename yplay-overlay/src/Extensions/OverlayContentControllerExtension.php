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
            EmailField::create('Email', 'Ihre E-Mail-Adresse')->setAttribute('Class','uk-input'),
            NocaptchaField::create('Captcha')
        );

        $actions = new FieldList(
            FormAction::create('cancel')->setTitle($this->owner->Overlay()->CloseButtonText)->addExtraClass('uk-button button-'.$this->owner->Overlay()->CloseButtonBackground.' uk-modal-close')->setUseButtonTag(true),
            FormAction::create('registerToNewsletter')->setTitle($this->owner->Overlay()->ValidButtonText)->addExtraClass('uk-button button-PrimaryBackground')->addExtraClass('dk-button-icon')->setUseButtonTag(true)
            ->setAttribute('data-uk-icon','chevron-right')
        );

        $required = new RequiredFields(['Email']);

        $form = new Form($this->owner, 'NewsletterForm', $fields, $actions, $required);
        $form->addExtraClass('form-std uk-form-horizontal');
        $form->enableSpamProtection();
        return $form;
    }

    public function registerToNewsletter($data, Form $form){

        //TO DO : Newsletter API --> Waiting for tool choice

        //TO DO: Emails?

        $form->sessionMessage('Email ' . $data['Email'] . ' registriert!', 'success');

        //TO DO: Redirect to succss page?
        return $this->owner->redirectBack();
    }
}