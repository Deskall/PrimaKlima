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
use SilverStripe\Control\Email\Email;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;

class ConfiguratorPageController extends PageController
{
   private static $allowed_actions = ['UnknownDoseForm'];

   public function activeCategories(){
    $activePLZ = $this->getRequest()->getSession()->get('active_plz');
    $categories = ProductCategory::get()->filter('isVisible',1);
    $activeCategories = new ArrayList();
    foreach ($categories as $cat) {
      $data = new ArrayData();
      $data->setField('category',$cat);
      $data->setField('disabled',$cat->isInactive($cart, $activePLZ));
      $data->setField('mandatory',$cat->isMandatory($activePLZ));
      $data->setField('unavailable',$cat->isUnavailable($activePLZ));
      // $data->setField('activeDependencies',$cat->hasDependencies($activePLZ));
      $activeCategories->push($data);
    }
    return $activeCategories;
   }

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
               TextField::create('PLZ','PLZ')->setAttribute('class','uk-input')->addExtraClass('uk-display-inline-block uk-width-1-4'),
               TextField::create('Ort','Ort')->setAttribute('class','uk-input')->addExtraClass('uk-display-inline-block uk-width-3-4'),
               TextField::create('Telefon','Tel.')->setAttribute('class','uk-input')->setAttribute('intlTelNumber',true),
               TextareaField::create('Nachricht','Ihre Nachricht')->setAttribute('class','uk-textarea')
         ),
         new FieldList(
            FormAction::create('sendDoseForm', _t('SHOP.SENDNOW', 'Anfrage jetzt senden'))->setUseButtonTag(true)->addExtraClass('uk-button button-PrimaryBackground')
         ),
         RequiredFields::create(['Anrede','Name','Email','Email2','Telefon','Address','PLZ','Ort'])
      );
     
      $form->addExtraClass('form-std');
      $form->setTemplate('Forms/UnknownDoseForm');
      $form->enableSpamProtection();
   
      return $form;
   }

   public function sendDoseForm($data,$form){
      try {
          $config = SiteConfig::current_site_config();
          $str = $this->parseString($config->UnknownDoseEmailContent, $data);
          $html = new DBHTMLText();
          $html->setValue($str);
          $Body = $this->renderWith('Emails/base_email',array('Subject' => $config->UnknownDoseEmailSubject, 'Lead' => '', 'Body' => $html, 'Footer' => '', 'SiteConfig' => $config));
          $email = new Email($config->UnknownDoseEmailSender, $data['Email'],$config->UnknownDoseEmailSubject, $Body);
          $email->setBCC($config->Email);
          $email->send();
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

   public function parseString($string, $data)
   {
       $table = '<table>';
       unset($data['SecurityID']);
       unset($data['g-recaptcha-response']);
       unset($data['Email2']);
       foreach ($data as $key => $value) {
           if ($value != "") {
               $table .= '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';
           }
       }
       $table .= '</table>';

       $variables = array(
           '$Name' => $data['Name'],
           '$Daten' => $table
       );

       return str_replace(array_keys($variables), array_values($variables), $string);
   }

}