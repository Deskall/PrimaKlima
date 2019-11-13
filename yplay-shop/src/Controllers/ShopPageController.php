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
      $date = new \DateTime();
      $date->modify('-18 years');
      $form = new Form(
         $this,
         'OrderForm',
         new FieldList(
            CompositeField::create(
               HeaderField::create('AddressTitle','Ihre Angaben',3),
               DropdownField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau'])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Bitte wählen')),
               TextField::create('Name','Name')->setAttribute('class','uk-input'),
               TextField::create('FirstName','Vorname')->setAttribute('class','uk-input'),
               EmailField::create('Email','E-Mail')->setAttribute('class','uk-input'),
               TextField::create('Phone','Tel.')->setAttribute('class','uk-input'),
               DateField::create('Birthday','Geburstdatum')->setAttribute('class','uk-input')->setAttribute('min','1900.01.01')->setAttribute('max',$date->format('Y.m.d')),
               TextField::create('Address','Adresse')->setAttribute('class','uk-input'),
               TextField::create('PostalCode','PLZ')->setAttribute('class','uk-input'),
               TextField::create('City','Stadt')->setAttribute('class','uk-input'),
               DropdownField::create('Country','Land')->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('ch'),
               CheckboxField::create('BillSameAddress','identische Rechnungsadresse?')->setAttribute('class','uk-checkbox')->setValue(1)
            )->setName('AddressFields'),
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
            FormAction::create('doOrder', _t('SHOP.BUYNOW', 'Jetzt bestellen'))->addExtraClass('uk-button')
         ),
         RequiredFields::create(['Gender','Name','FirstName','Email','Birthday','Address','PostalCode','City','Country'])
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
      //Add Dependent Fields
      //1. Phone
      if ($cart->hasCategory('yplay-talk')){
         $form->Fields()->push(HeaderField::create('PhoneTitle','Ihre Telefonnummer',3));
         $form->Fields()->push(OptionSetField::create('PhoneOption','Label',['existing' => 'Bestehende Rufnummer(n) übernehmen', 'new' => 'Neue Rufnummer(n) bestellen', 'wish' => 'Wunschnummer bestellen']));
         $form->Fields()->push(TextField::create('ExistingPhone','Bei einer Übernahme der Rufnummer die bestehenden Verträge bitte NICHT kündigen. Wir übernehmen dies für Sie.'));
         $form->Fields()->push(TextField::create('WishPhone','Label'));
         
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

            return $this->redirect('shop/bestellung-bestaetigt');

      }
      
      

      return $this->httpError(404);
      
   }


   public function filteredOptions(){
      $options = ProductOption::get()->filter('GroupID',0)->filterByCallback(function($item, $list) {
          return ($item->shouldDisplay());
      })->sort('CategoryTitle');
      
      return GroupedList::create($options);
   }

   public function activeCart(){
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      if ($id){
         $cart = ShopCart::get()->byId($id);
         return $cart;
      }
      return null;
   }

}