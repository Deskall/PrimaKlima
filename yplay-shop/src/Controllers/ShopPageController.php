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
use SilverStripe\Forms\ReadonlyField;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ValidationException;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Director;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\ORM\GroupedList;
use SilverStripe\ORM\FieldType\DBHTMLText;
use UndefinedOffset\NoCaptcha\Forms\NocaptchaField;

class ShopPageController extends PageController
{
   private static $allowed_actions = ['OrderForm','OrderPackageLink', 'OrderProductLink'];

   private static $url_handlers = [
       'paket/$ID' => 'OrderPackageLink',
       'produkt/$ID' => 'OrderProductLink'  
   ];


   public function index(){
      
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

      return [];
      
   }

    /* Update the Cart and link to Order Page */
   public function OrderPackageLink(){ 
      $this->owner->getRequest()->getSession()->clear('chosen_product');
      $packageID = $this->owner->getRequest()->param('ID');
      //If no active PLZ we redirect to Configurator
      if (!$this->owner->activePLZ()){
         //First we save the selected package in session
         if ($packageID){
             $this->owner->getRequest()->getSession()->set('chosen_package',$packageID);
         }
        return $this->owner->redirect($this->owner->ConfiguratorPage()->Link(),302); 
      }

      //Fetch cart or create if null
      $id = $this->owner->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart){
         $cart = new ShopCart();  
      }
      $cart->IP = $this->owner->getRequest()->getIp();

      //fetch package and link it
      
      if ($packageID){
        $package = Package::get()->byId($packageID);
        if ($package){
           $cart->PackageID = $package->ID;
           if ( $cart->Availability != "Immer"){
              $cart->Availability = $package->Availability;
           }
           $this->owner->getRequest()->getSession()->set('active_offer',$cart->Availability);
           $cart->Products()->removeAll();
        }
      }
      
      $cart->write();
      $this->owner->getRequest()->getSession()->set('shopcart_id',$cart->ID);


      return $this->owner->redirect($this->owner->ShopPage()->Link(),302);
   }

    /* Update the Cart and link to Order Page */
   public function OrderProductLink(){
      $this->owner->getRequest()->getSession()->clear('chosen_package');
      $productID = $this->owner->getRequest()->param('ID');
      //If no active PLZ we redirect to Configurator
      if (!$this->owner->activePLZ()){
         //First we save the selected package in session
         if ($productID){
             $this->owner->getRequest()->getSession()->set('chosen_product',$productID);
         }
        return $this->owner->redirect($this->owner->ConfiguratorPage()->Link(),302); 
      }

      //Fetch cart or create if null
      $id = $this->owner->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart){
         $cart = new ShopCart();  
      }
      $cart->IP = $this->owner->getRequest()->getIp();

      //fetch package and link it
      
      if ($productID){
        $product = Product::get()->byId($productID);
        if ($product){
            $cart->Products()->removeAll();
            $cart->PackageID = 0;
            $cart->Products()->add($product);
            if ($product->Availability != "Immer"){
               $cart->Availability = $product->Availability;
            }
            $this->owner->getRequest()->getSession()->set('active_offer',$cart->Availability);
        }
      }
      
      $cart->write();
      $this->owner->getRequest()->getSession()->set('shopcart_id',$cart->ID);
      return $this->owner->redirect($this->owner->ConfiguratorPage()->Link(),302);
   }

   public function OrderForm(){
      Requirements::javascript('yplay-shop/javascript/jquery.validate.min.js');
      Requirements::javascript('yplay-shop/javascript/messages_de.min.js');
      Requirements::javascript('yplay-shop/javascript/customRules.js');
      $date = new \DateTime();
      $max = new \DateTime();
      $date = $date->modify('-18 years');
      $max = $max->modify('-18 years + 1 day');
      $config = SiteConfig::current_site_config();
      $agbpage = $config->AGBPage();
      $form = new Form(
         $this,
         'OrderForm',
         new FieldList(
            OptionsetField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau']),
            CompositeField::create(
               TextField::create('Name','Name')->setAttribute('class','uk-input'),
               TextField::create('FirstName','Vorname')->setAttribute('class','uk-input'),
               $birthday = DateField::create('Birthday','Geburstdatum')->setAttribute('minDate','1900.01.01')->setAttribute('maxDate',$max->format('Y.m.d'))->setAttribute('class','uk-input')
            )->setName('Step1'),
            CompositeField::create(
               EmailField::create('Email','E-Mail')->setAttribute('class','uk-input'),
               TextField::create('Phone','Tel.')->setAttribute('class','uk-input')->setAttribute('intlTelNumber',true)
            )->setName('Step2'),
            CompositeField::create(
               TextField::create('Address','Adresse')->setAttribute('class','uk-input'),
               ReadonlyField::create('PostalCode','PLZ')->setAttribute('class','uk-input'),
               ReadonlyField::create('City','Stadt')->setAttribute('class','uk-input'),
               CheckboxField::create('BillSameAddress','identische Rechnungsadresse?')->setAttribute('class','uk-checkbox')
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
               // CheckboxField::create('Newsletter','Ich abonniere den Newsletter'),
               CheckboxField::create('AGB',DBHTMLText::create()->setValue('Ich bin mit den <a href="'.$agbpage->Link().'" target="_blank" title="AGB anschauen">AGB</a> einverstanden')),
               NocaptchaField::create('Captcha')
            )->setName('OtherFields'),
            HiddenField::create('ExistingCustomer')
         ),
         new FieldList(
            FormAction::create('doOrder', _t('SHOP.BUYNOW', 'Bestellung abschicken'))->addExtraClass('uk-button')
         ),
         RequiredFields::create(['Gender','Name','FirstName','Birthday','Email','Phone','Address','AGB'])
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
            $form->Fields()->push(OptionSetField::create('PhoneOption','Label',['existing' => 'Bestehende Rufnummer(n) übernehmen', 'new' => 'Neue Rufnummer(n) bestellen', 'wish' => 'Wunschnummer bestellen'])->setAttribute('required','required'));
            $form->Fields()->push(TextField::create('ExistingPhone','Bei einer Übernahme der Rufnummer die bestehenden Verträge bitte NICHT kündigen. Wir übernehmen dies für Sie.')->setAttribute('placeholder','Bitte geben Sie Ihre bestehende Nummer ein.'));
            $form->Fields()->push(TextField::create('WishPhone','Label')->setAttribute('placeholder','Ihre Wunschnummer'));
            $form->getValidator()->addRequiredField('PhoneOption');
         }
         //2. Mobile
         if ($cart->hasCategory('yplay-mobile')){
            $mobileAGB = $config->MobileAGBPage(); 
            $form->Fields()->insertAfter('AGB',CheckboxField::create('AGBMobile',DBHTMLText::create()->setValue('Ich bin mit den <a href="'.$mobileAGB->Link().'" target="_blank" title="Mobile AGB anschauen">Mobile AGB</a> einverstanden'))->setAttribute('required','required'));
            $form->getValidator()->addRequiredField('AGBMobile');
         }

         //3. Glasfaserdose
         if ($cart->Availability == "Fiber" || 
            ( !$cart->Availability && $this->activePLZ()->exists() && $this->activePLZ()->Availability == "Fiber")
         ){
            $form->Fields()->insertBefore('Comments',TextField::create('Glasfaserdose','Bitte geben Sie Ihre Glasfaserdosen-Nummer ein:')->setAttribute('placeholder','B.110.123.456.X'))->setAttribute('required','required');
            $form->Fields()->insertAfter('Glasfaserdose',CheckboxField::create('UnknownGlasfaserdose','Ich kenne meine Glasfaserdosen-Nummer nicht.'));
         }
      }
      
     
      $form->addExtraClass('form-std');
      $form->setTemplate('Forms/OrderForm');
      $form->loadDataFrom($cart);

   
      return $form;
   }

   public function doOrder($data,$form){
      
      //Validate Recaptcha (to finish)
      $form->Fields()->dataFieldByName('Captcha')->validate($form->getValidator());
     
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
            $order->write();
            //Create Receipt
            // $order->generatePDF();
            //Send Confirmation Email
            $order->sendEmail();

            $this->getRequest()->getSession()->set('orderID',$order->ID);
            $this->getRequest()->getSession()->set('customerID',$customer->ID);

            //update and clear cart (Delete ?)
            $cart->Purchased = true;
            $cart->OrderID = $order->ID;
            $cart->CustomerID = $customer->ID;
            $cart->write();
            $this->getRequest()->getSession()->clear('shopcart_id');

            return $this->redirect($this->RedirectPage()->Link());

      }
      
      

      return $this->httpError(404);
      
   }



}