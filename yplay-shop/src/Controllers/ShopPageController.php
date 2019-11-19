<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DateField;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ValidationException;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Director;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\ORM\GroupedList;

class ShopPageController extends PageController
{
   private static $allowed_actions = ['OrderForm'];

   public function init(){
      parent::init();
      if (!$this->getRequest()->requestVar('CMSPreview')){
         //redirect if empty cart
         $id = $this->getRequest()->getSession()->get('shopcart_id');
         $cart = null;
         if ($id){
            $cart = ShopCart::get()->byId($id);
         }
         if (!$cart ){
            return $this->redirect($this->ConfiguratorPage()->Link(), 302);
         }
      }
      
   }

   public function OrderForm(){
      Requirements::javascript('yplay-shop/javascript/jquery.validate.min.js');
      Requirements::javascript('yplay-shop/javascript/messages_de.min.js');
      Requirements::javascript('yplay-shop/javascript/customRules.js');
      $date = new \DateTime();
      $max = new \DateTime();
      $date = $date->modify('-18 years');
      $max = $max->modify('-18 years + 1 day');
      $form = new Form(
         $this,
         'OrderForm',
         new FieldList(
            HeaderField::create('AddressTitle','Ihre Angaben',3),
            CompositeField::create(
               OptionsetField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau']),
               TextField::create('Name','Name')->setAttribute('class','uk-input'),
               TextField::create('FirstName','Vorname')->setAttribute('class','uk-input'),
               DateField::create('Birthday','Geburstdatum')->setValue($date->format('Y-m-d'))->setAttribute('minDate','1900.01.01')->setAttribute('maxDate',$max->format('Y.m.d'))->setAttribute('class','uk-input')
            )->setName('Step1'),
            CompositeField::create(
               EmailField::create('Email','E-Mail')->setAttribute('class','uk-input'),
               TextField::create('Phone','Tel.')->setAttribute('class','uk-input')->setAttribute('intlTelNumber',true)
            )->setName('Step2'),
            CompositeField::create(
               TextField::create('Address','Adresse')->setAttribute('class','uk-input'),
               ReadonlyField::create('PostalCode','PLZ')->setAttribute('class','uk-input')->setValue($this->activePLZ()->Code),
               ReadonlyField::create('City','Stadt')->setAttribute('class','uk-input')->setValue($this->activePLZ()->City),
               CheckboxField::create('BillSameAddress','identische Rechnungsadresse?')->setAttribute('class','uk-checkbox')->setValue(1)
            )->setName('Step3'),
            CompositeField::create(
               HeaderField::create('BillTitle','Rechnungsadresse',3),
               TextField::create('BillAddress','Adresse'),
               TextField::create('BillPostalCode','PLZ'),
               TextField::create('BillCity','Stadt'),
               DropdownField::create('BillCountry','Land')->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('ch')
            )->setName('BillFields'),
            CompositeField::create(
               HeaderField::create('OtherTitle','Weitere Angaben',3),
               TextareaField::create('Comments','Bemerkungen'),
               CheckboxField::create('Newsletter','Ich abonniere den Newsletter'),
               CheckboxField::create('AGB','Ich bin mit den AGB einverstanden')
            )->setName('OtherFields'),
            HiddenField::create('ExistingCustomer')
         ),
         new FieldList(
            FormAction::create('doOrder', _t('SHOP.BUYNOW', 'Bestellung abschicken'))->addExtraClass('uk-button')
         ),
         RequiredFields::create(['Gender','Name','FirstName','Birthday','Email','Phone','Address'])
      );
      // $member = Security::getCurrentUser();
      // if ($member){
      //    $customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
      //    if ($customer){
      //       $form->loadDataFrom($customer);
      //       $form->Fields()->fieldByName('Name')->setValue($member->Surname);
      //       $form->Fields()->fieldByName('Vorname')->setValue($member->FirstName);
      //    }
      // }

      //Retrive Cart
      $cart = ShopCart::get()->byId($this->getRequest()->getSession()->get('shopcart_id'));
      if ($cart){
         //Add Dependent Fields
         //1. Phone
         if ($cart->hasCategory('yplay-talk')){
            $form->Fields()->push(HeaderField::create('PhoneTitle','Ihre Telefonnummer',3));
            $form->Fields()->push(OptionSetField::create('PhoneOption','Label',['existing' => 'Bestehende Rufnummer(n) übernehmen', 'new' => 'Neue Rufnummer(n) bestellen', 'wish' => 'Wunschnummer bestellen']));
            $form->Fields()->push(TextField::create('ExistingPhone','Bei einer Übernahme der Rufnummer die bestehenden Verträge bitte NICHT kündigen. Wir übernehmen dies für Sie.'));
            $form->Fields()->push(TextField::create('WishPhone','Label'));
            
         }
         //2. Mobile
         if ($cart->hasCategory('yplay-mobile')){
            $form->Fields()->insertAfter('AGB',CheckboxField::create('AGBMobile','Ich bin mit den Mobile AGB einverstanden'));
         }
      }
      

      $form->addExtraClass('uk-form-horizontal form-std');
      $form->setTemplate('Forms/OrderForm');
      // if(is_array($this->getRequest()->getSession()->get('BuyBillForm'))) {
      //    $form->loadDataFrom($this->getRequest()->getSession()->get('BuyBillForm'));
      // }
      return $form;
   }

   public function doOrder($data,$form){

      //Retrive Cart
      $cartId = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = ($cartId) ? ShopCart::get()->byId($cartId) : null;

      if ($cart && !$cart->isEmpty()){
            //Create and fill the order
               $order = new ShopOrder();
               $form->saveInto($order);
               
               //Customer
               $customer = ShopCustomer::get()->filter('Email',$data['Email'])->first();
               if (!$customer){
                  $customer = new ShopCustomer();
                  $form->saveInto($customer);
                  $customer->write();
               }
               $order->CustomerID = $customer->ID;
              
            try {
               //Write order
               $order->write();
               
            } catch (ValidationException $e) {
               $validationMessages = '';
               foreach($e->getResult()->getMessages() as $error){
                  $validationMessages .= $error['message']."\n";
               }
               $form->sessionMessage($validationMessages, 'bad');
               return $this->redirectBack();
            }

            //Assign items
            //Package
            if ($cart->Package()->exists()){
               $item = new OrderItem();
               $item->createFromPackage($cart->Package(),$data['ExistingCustomer']);
               $item->OrderID = $order->ID;
               $item->write();
            }
            //Products
            if ($cart->Products()->exists()){
               foreach ($cart->Products() as $p) {
                  $item = new OrderItem();
                  $item->createFromProduct($p,$data['ExistingCustomer']);
                  $item->OrderID = $order->ID;
                  $item->write();
               }
            }

            $order->MonthlyPrice = $cart->TotalMonthlyPrice;
            $order->UniquePrice = $cart->TotalUniquePrice;
            
            //Create Receipt
            // $order->generatePDF();
            //Send Confirmation Email
            $order->sendEmail();

            $this->getRequest()->getSession()->set('orderID',$order->ID);
            $this->getRequest()->getSession()->set('customerID',$customer->ID);

            //update and clear cart
            $cart->Purchased = true;
            $cart->OrderID = $order->ID;
            $cart->write();
            $this->getRequest()->getSession()->clear('shopcart_id');

            return $this->redirect($this->RedirectPage()->Link());

      }
      
      

      return $this->httpError(404);
      
   }



}