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

class ShopPageController extends PageController
{
   private static $allowed_actions = ['OrderForm'];

   public function init(){
      parent::init();
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

   public function OrderForm(){
      Requirements::javascript('silverstripe/admin: client/dist/js/vendor.js');
      Requirements::javascript('silverstripe/admin: client/dist/js/bundle.js');



      $form = new Form(
         $this,
         'OrderForm',
         new FieldList(
            DropdownField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau'])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Bitte wählen')),
            TextField::create('Name','Name'),
            TextField::create('FirstName','Vorname'),
            EmailField::create('Email','E-Mail'),
            TextField::create('Phone','Tel.'),
            DateField::create('Birthday','Geburstdatum'),
            TextField::create('Address','Adresse'),
            TextField::create('PostalCode','PLZ'),
            TextField::create('City','Stadt'),
            DropdownField::create('Country','Land')->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('ch'),
            CheckboxField::create('BillSameAddress','identische Rechnungsadresse?')->setValue(1),
            Wrapper::create(CompositeField::create(
               HeaderField::create('BillTitle','Rechnungsadresse',3),
               TextField::create('BillAddress','Adresse'),
               TextField::create('BillPostalCode','PLZ'),
               TextField::create('BillCity','Stadt'),
               DropdownField::create('BillCountry','Land')->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('ch')
            )->setName('BillFields'))->hideUnless('BillSameAddress')->isNotChecked()->end(),
            
            HiddenField::create('isClient')
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
      if ($cart->hasCategory('yplay-telefonie')){
        
         $form->Fields()->push(OptionSetField::create('PhoneOption','Label',['existing' => 'Bestehende Rufnummer(n) übernehmen', 'new' => 'Neue Rufnummer(n) bestellen', 'wish' => 'Wunschnummer bestellen']));
         $form->Fields()->push(TextField::create('ExistingPhone','Bei einer Übernahme der Rufnummer die bestehenden Verträge bitte NICHT kündigen. Wir übernehmen dies für Sie.')->displayIf('PhoneOption')->isEqualTo("existing")->end());
         $form->Fields()->push(TextField::create('WishPhone','Label')->displayIf('PhoneOption')->isEqualTo("wish")->end());
         
      }

      $form->addExtraClass('uk-form-horizontal form-std');
      // if(is_array($this->getRequest()->getSession()->get('BuyBillForm'))) {
      //    $form->loadDataFrom($this->getRequest()->getSession()->get('BuyBillForm'));
      // }
      return $form;
   }

   public function doOrder($data,$form){

      //Link to date
      if (isset($data['ProductID']) && !empty($data['ProductID'])){
         $product = Product::get()->byId($data['ProductID']);
         $quantity = $data['Quantity'];
         if ($product){

            //Create and fill the order
               $order = new ShopOrder();
               $form->saveInto($order);
               $order->Price = $product->currentPrice() * $quantity + $order->getProductConfig()->TransportCost;

               //Customer
               $member = (Security::getCurrentUser()) ? Security::getCurrentUser() : Member::get()->filter('Email',$data['Email'])->first();
               if (!$member){
                  $member = new Member();
                  $member->Surname = $data['Name'];
                  $member->FirstName = $data['Vorname'];
                  $member->Email = $data['Email'];
                  $member->write();

                  $customer = new ShopCustomer();
                  $customer->Gender = $data['Gender'];
                  $customer->Company = $data['Company'];
                  $customer->PostalCode = $data['PostalCode'];
                  $customer->Address = $data['Address'];
                  $customer->City = ucfirst(strtolower($data['City']));
                  $customer->Country = strtolower($data['Country']);
                  $customer->UIDNumber = $data['UIDNumber'];
                  $customer->MemberID = $member->ID;
                  $customer->write();
                  $customer->sendLoginData();
               }
               else{
                  $customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
                  if ($customer){
                     $customer->Gender = $data['Gender'];
                     $customer->UIDNumber = $data['UIDNumber'];
                     $customer->Company = $data['Company'];
                     $customer->write();
                  }
                  else{
                     $customer = new ShopCustomer();
                     $customer->Gender = $data['Gender'];
                     $customer->Company = $data['Company'];
                     $customer->PostalCode = $data['PostalCode'];
                     $customer->Address = $data['Address'];
                     $customer->City = ucfirst(strtolower($data['City']));
                     $customer->Country = strtolower($data['Country']);
                     $customer->UIDNumber = $data['UIDNumber'];
                     $customer->MemberID = $member->ID;
                     $customer->write();
                  }
               }
               $member->addToGroupByCode('shop-kunden');
               $identityStore = Injector::inst()->get(IdentityStore::class);
               $identityStore->logIn($member, false, $this->getRequest());
               $order->CustomerID = $customer->ID;
               $order->isPaid = false;
               $order->PaymentType = 'bill';


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
            
            //Create Receipt
            $order->generatePDF();
            //Send Confirmation Email
            $order->sendEmail();

            $this->getRequest()->getSession()->set('orderID',$order->ID);
            $this->getRequest()->getSession()->set('customerID',$member->ID);

            return $this->redirect('shop/bestellung-bestaetigt');

         }
      
      }

      return $this->httpError(404);
      
   }

}