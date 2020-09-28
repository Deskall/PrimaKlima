<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ValidationException;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ConfiguratorPageController extends PageController
{
   private static $allowed_actions = ['UnknownDoseForm'];

   public function UnknownDoseForm(){
      Requirements::javascript('yplay-shop/javascript/jquery.validate.min.js');
      Requirements::javascript('yplay-shop/javascript/messages_de.min.js');
      Requirements::javascript('yplay-shop/javascript/customRules.js');
      
      $config = SiteConfig::current_site_config();

      $form = new Form(
         $this,
         'UnknownDoseForm',
         new FieldList(
               OptionsetField::create('Anrede','Anrede',['Herr' => 'Herr','Frau' => 'Frau']),
               TextField::create('Name','Name und Vorname')->setAttribute('class','uk-input'),
               EmailField::create('Email','E-Mail')->setAttribute('class','uk-input'),
               $email2 = EmailField::create('Email2','E-Mail Prüfung')->setAttribute('class','uk-input')->setAttribute('validateEmail',true)->setDescription('Bitte geben Sie wieder Ihre E-Mail-Adresse ein.')->setAttribute('autocomplete','new-email-validation-'.rand()),
               TextField::create('Adresse','Adresse')->setAttribute('class','uk-input'),
               TextField::create('PLZ','PLZ')->setAttribute('class','uk-input'),
               TextField::create('Ort','Ort')->setAttribute('class','uk-input'),
               TextField::create('Telefon','Tel.')->setAttribute('class','uk-input')->setAttribute('intlTelNumber',true),
               TextareaField::create('Nachricht','Ihre Nachricht')->setAttribute('class','uk-textarea')
         ),
         new FieldList(
            FormAction::create('sendDoseForm', _t('SHOP.SENDNOW', 'Anfrage jetzt senden'))->setUseButtonTag(true)->addExtraClass('uk-button button-PrimaryBackground')
         ),
         RequiredFields::create(['Anrede','Name','Email','Email2','Telefon','Address','PLZ','Ort'])
      );
     
      $form->addExtraClass('form-std');
      $form->enableSpamProtection();
   
      return $form;
   }

   public function sendDoseForm($data,$form){
      
   }

}