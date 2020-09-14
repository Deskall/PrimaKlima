<?php


use DNADesign\Elemental\Models\ElementalArea;
use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\HiddenField;
use UndefinedOffset\NoCaptcha\Forms\NocaptchaField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\Requirements;

class OverlayContentControllerExtension extends Extension
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'handleElement',
        'NewsletterForm',
        'BewertungForm'
    );

    public function onAfterInit(){
        if ($this->owner->Overlay()->exists() && $this->owner->Overlay()->Type == "Bewertung"){
            Requirements::javascript('yplay-overlay/javascript/rater.min.js');
        }
    }

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
            CheckboxField::create('AGB',DBHTMLText::create()->setValue('<label for="Form_NewsletterForm_AGB">'.$this->owner->Overlay()->AGBText.'</label>'))->setAttribute('class','uk-checkbox'),
            NocaptchaField::create('Captcha')
        );

        $actions = new FieldList(
            FormAction::create('cancel')->setTitle($this->owner->Overlay()->CloseButtonText)->addExtraClass('uk-button button-'.$this->owner->Overlay()->CloseButtonBackground.' uk-modal-close')->setUseButtonTag(true),
            FormAction::create('registerToNewsletter')->setTitle($this->owner->Overlay()->ValidButtonText)->addExtraClass('uk-button button-PrimaryBackground')->addExtraClass('dk-button-icon')->setUseButtonTag(true)
            ->setAttribute('data-uk-icon','chevron-right')
        );

        $required = new RequiredFields(['Email', 'AGB']);

        $form = new Form($this->owner, 'NewsletterForm', $fields, $actions, $required);
        $form->addExtraClass('form-std');
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

    public function BewertungForm(){
        $fields = new FieldList(
            HiddenField::create('OverlayID')->setValue($this->owner->OverlayID),
            HiddenField::create('Datum')->setValue(date('d.m.Y')),
            HiddenField::create('PLZ')->setValue($this->owner->getRequest()->getSession()->get('active_plz')),
            HiddenField::create('Bewertung'),
            TextareaField::create('Bemerkungen','Bemerkungen')->setAttribute('maxlength',500)->setAttribute('class','uk-textarea')->setRows('10'),
            CheckboxField::create('AGB',DBHTMLText::create()->setValue('<label for="Form_BewertungForm_AGB">'.$this->owner->Overlay()->AGBText.'</label>'))->setAttribute('class','uk-checkbox')
        );

        $actions = new FieldList(
            FormAction::create('cancel')->setTitle($this->owner->Overlay()->CloseButtonText)->addExtraClass('uk-button button-'.$this->owner->Overlay()->CloseButtonBackground.' uk-modal-close')->setUseButtonTag(true),
            FormAction::create('doRate')->setTitle($this->owner->Overlay()->ValidButtonText)->addExtraClass('uk-button button-PrimaryBackground')->addExtraClass('dk-button-icon')->setUseButtonTag(true)
            ->setAttribute('data-uk-icon','chevron-right')
        );

        $required = new RequiredFields(['Bewertung','AGB']);

        $form = new Form($this->owner, 'BewertungForm', $fields, $actions, $required);
        $form->addExtraClass('form-std');
        $form->enableSpamProtection();
        return $form;
    }

    public function doRate($data, Form $form){
        try {
            //Save Rate
            $rate = new Rate();
            $form->saveInto($rate);
            $rate->write();

            //Send mails
            // $config = SiteConfig::current_site_config();
            // $str = $this->parseString($config->ProductEmailContent, $data);
            // $html = new DBHTMLText();
            // $html->setValue($str);
            // $Body = $this->renderWith('Emails/base_email',array('Subject' => $config->ProductEmailSubject, 'Lead' => '', 'Body' => $html, 'Footer' => '', 'SiteConfig' => $config));
            // $email = new Email($config->Email, $data['Email'],$config->ProductEmailSubject, $Body);
            // $email->setBCC($config->Email);
            // $email->send();
            $form->sessionMessage('Vielen Dank ' . $data['Name']."\n".'Ihre Anfrage wurde erfolgreich gesendet', 'success');

        } catch (ValidationException $e) {
            $validationMessages = '';
            foreach($e->getResult()->getMessages() as $error){
                $validationMessages .= $error['message']."\n";
            }
            $form->sessionMessage($validationMessages, 'bad');
            return $this->redirectBack();
        }

        return $this->redirectBack();

    }
}
