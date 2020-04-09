<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DateField;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ValidationException;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;
use SilverStripe\Security\Member;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Director;
use SilverStripe\Security\MemberAuthenticator\MemberLoginForm;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;
use UndefinedOffset\NoCaptcha\Forms\NocaptchaField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ShopPageController extends PageController{
	private static $allowed_actions = ['CreateTransaction','TransactionCompleted','CheckoutForm', 'VoucherForm'];

	private static $url_handlers = [
		'transaktion-erstellen' => 'CreateTransaction',
		'transaktion-abgeschlossen' => 'TransactionCompleted'
	];

	public function init(){
		parent::init();
		
	}

	public function activeCart(){
		$id = $this->getRequest()->getSession()->get('shopcart_id');
		if ($id){
		   $cart = ShopCart::get()->byId($id);
		   return $cart;
		}
		return null;
		// return ShopCart::get()->last();
	}


	public function CheckoutForm(){
		// $customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
		$privacyPolicy = PrivatePolicyPage::get()->first();
		$ppLink = ($privacyPolicy) ? $privacyPolicy->Link() : '/';

		Requirements::javascript("https://www.paypal.com/sdk/js?client-id=".SiteConfig::current_site_config()->PayPalClientID."&currency=CHF&locale=de_CH");
		Requirements::javascript("deskall-shop/javascript/shop.js");
		Requirements::javascript("deskall-shop/javascript/jquery.validate.min.js");
		Requirements::javascript("deskall-shop/javascript/messages_de.min.js");
		$fields = FieldList::create(
			HiddenField::create('CartID')->setValue($this->activeCart()->ID),
			HiddenField::create('PaymentType'),
			// HiddenField::create('CustomerID')->setValue($customer->ID),
			// HiddenField::create('VoucherID'),
			CompositeField::create(
				TextField::create('Company',_t(__CLASS__.'.Company','Firma'))->setValue('Deskall'),
				DropdownField::create('Gender',_t(__CLASS__.'.Gender','Anrede *'), ['Herr' => 'Herr','Frau' => 'Frau'])->setAttribute('class','uk-select')->setValue('Herr'),
				TextField::create('FirstName',_t(__CLASS__.'.FirstName','Vorname *'))->setAttribute('data-required',true)->setValue('Guillaume'),
				TextField::create('Name',_t(__CLASS__.'.Name','Name *'))->setAttribute('data-required',true)->setValue('Pacilly'),
				TextField::create('Street',_t(__CLASS__.'.Street','Strasse *'))->setAttribute('data-required',true)->setValue('Oltnerstrasse 85'),
				TextField::create('Address',_t(__CLASS__.'.Address','Adresse')),
				TextField::create('PostalCode',_t(__CLASS__.'.PostalCode','Postleitzahl *'))->setAttribute('data-required',true)->setValue('4663'),
				TextField::create('City',_t(__CLASS__.'.City','Stadt *'))->setAttribute('data-required',true)->setValue('Aarburg'),
				TextField::create('Region',_t(__CLASS__.'.Region','Bundesland')),
				DropdownField::create('Country',_t(__CLASS__.'.Country','Land *'))->setSource(i18n::getData()->getCountries())->setValue('ch')->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen *'))->setAttribute('data-required',true),
				EmailField::create('Email',_t(__CLASS__.'.Email','E-Mail-Adresse *'))->setAttribute('data-required',true)->setValue('guillaume.pacilly@gmail.com'),
				TextField::create('Phone',_t(__CLASS__.'.Phone','Telefon *'))->setAttribute('data-required',true)->setValue('0788911689'),
				TextareaField::create('Additional',_t(__CLASS__.'.Additional','Zusätzliche Informationen'))->setRows(3),
				CheckboxField::create('DeliverySameAddress',_t(__CLASS__.'.DeliverySameAddress','Diese Adresse auch als Lieferadresse verwenden?'))->setValue(1)->setAttribute('class','uk-checkbox')
			)->setName('BillFields'),
			CompositeField::create(
				TextField::create('DeliveryCompany',_t(__CLASS__.'.Company','Firma')),
				DropdownField::create('DeliveryGender',_t(__CLASS__.'.Gender','Anrede *'), ['Herr' => 'Herr','Frau' => 'Frau']),
				TextField::create('DeliveryFirstName',_t(__CLASS__.'.FirstName','Vorname *'))->setAttribute('data-required',true),
				TextField::create('DeliveryName',_t(__CLASS__.'.Name','Name *'))->setAttribute('data-required',true),
				TextField::create('DeliveryStreet',_t(__CLASS__.'.Street','Strasse *'))->setAttribute('data-required',true),
				TextField::create('DeliveryAddress',_t(__CLASS__.'.Address','Adresse'))->setAttribute('data-required',true),
				TextField::create('DeliveryPostalCode',_t(__CLASS__.'.PostalCode','Postleitzahl *'))->setAttribute('data-required',true),
				TextField::create('DeliveryCity',_t(__CLASS__.'.City','Stadt *'))->setAttribute('data-required',true),
				TextField::create('DeliveryRegion',_t(__CLASS__.'.Region','Bundesland')),
				DropdownField::create('DeliveryCountry',_t(__CLASS__.'.Country','Land'))->setSource(i18n::getData()->getCountries())->setValue('ch')->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen *'))->setAttribute('data-required',true)
			)->setName('DeliveryFields'),
			CompositeField::create(
				// TextareaField::create('Comments','Bemerkungen'),
				CheckboxField::create('AGB',DBHTMLText::create()->setValue(_t(__CLASS__.'.AGB','Hiermit bestätige ich, dass ich sowohl die <a href="{link}" target="_blank">Datenschutzerklärung</a> wie auch die <a href="{link2}" target="_blank">AGB</a> gelesen habe und mit beiden einverstanden bin. *', ['link' => $ppLink, 'link2' => '/agb'])))->setAttribute('class','uk-checkbox'),
				NocaptchaField::create('Captcha')
				
			)->setName('SummaryFields')
		);
		$actions = new FieldList(FormAction::create('payBill', _t('SHOP.BUY', 'Jetzt kaufen'))->addExtraClass('uk-button button-blau')->setUseButtonTag(true)->setButtonContent('<i class="uk-margin-small-right" data-uk-icon="cart"></i>'._t('SHOP.BUY', 'Jetzt kaufen')));
		$required = RequiredFields::create(['AGB']);

		$form = new Form(
			$this,
			'CheckoutForm',
			$fields,
			$actions,
			$required
		);
		
		$form->setTemplate('Forms/CheckoutForm');
		$form->addExtraClass('uk-form-horizontal form-std');
		//Pre-fill Address fields
		// $fields = $form->Fields();
		// if ($customer->BillingAddressIsCompanyAddress){
		// 	$fields->dataFieldByName('BillingAddressCompany')->setValue($customer->Company);
		// 	$fields->dataFieldByName('BillingAddressStreet')->setValue($customer->Address);
		// 	$fields->dataFieldByName('BillingAddressPostalCode')->setValue($customer->PostalCode);
		// 	$fields->dataFieldByName('BillingAddressPlace')->setValue($customer->City);
		// 	$fields->dataFieldByName('BillingAddressCountry')->setValue($customer->Country);
		// }
		// else{
		// 	$fields->dataFieldByName('BillingAddressCompany')->setValue($customer->BillingAddressCompany);
		// 	$fields->dataFieldByName('BillingAddressStreet')->setValue($customer->BillingAddressStreet);
		// 	$fields->dataFieldByName('BillingAddressPostalCode')->setValue($customer->BillingAddressPostalCode);
		// 	$fields->dataFieldByName('BillingAddressPlace')->setValue($customer->BillingAddressPlace);
		// 	$fields->dataFieldByName('BillingAddressCountry')->setValue($customer->BillingAddressCountry);
		// }

		return $form;
	}

	//Payment for Bill and Cash
	public function payBill($data,$form){
		//retrieve cart
		$cart = $this->activeCart();
		if ($cart){
			//Create and fill the customer
			$customer = (ShopCustomer::get()->filter('Email',$data['Email'])->first()) ? ShopCustomer::get()->filter('Email',$data['Email'])->first() : new ShopCustomer();
			$customer->update($data);
			$customer->write();
			//Create and fill the order
			$order = new ShopOrder();
			$order->CustomerID = $customer->ID;
			$form->saveInto($order);
			$duplicateFromCart = ['IP', 'TotalPrice','DiscountPrice', 'TransportPrice', 'FullTotalPrice', 'VoucherID'];
			foreach ($duplicateFromCart as $key => $field) {
				$order->{$field} = $cart->{$field};
			}
			$order->isPaid = false;

			try {
				//Write order
				$order->write();
				//Update Voucher
				$order->Voucher()->Used = true;
				$order->Voucher()->Count = $order->Voucher()->count - 1;
				$order->Voucher()->write();

				foreach ($cart->Products() as $p) {
					$item = new OrderItem();
					$item->createFromProduct($p);
					$order->Items()->add($item);
				}

				//Create Receipt
				$order->generatePDF();
				//Send Confirmation Email (BCC to admin)
				$order->sendEmail();
				$this->getRequest()->getSession()->set('orderID',$order->ID);
				
				//clear cart
				$cart->delete();
				$this->getRequest()->getSession()->clear('shopcart_id');
								
				
				return $this->Redirect(SiteConfig::current_site_config()->SuccessfullPage()->Link());
				
			} catch (ValidationException $e) {
				$validationMessages = '';
				foreach($e->getResult()->getMessages() as $error){
					$validationMessages .= $error['message']."\n";
				}
				$form->sessionMessage($validationMessages, 'bad');
				return $this->redirectBack();
			}
						
		}
						
		//unguilty request, go back
		return $this->redirectBack();
	}

	private static function buildRequestBody($data)
    {
    	//1. Amount, if not we return null
    	
    	if ($data->amount && $data->email){
    		//2. Customer
    		$member = (Security::getCurrentUser()) ? Security::getCurrentUser() : Member::get()->filter('Email',$data->email)->first();
    		$customer = ($member) ? JobGiver::get()->filter('MemberID',$member->ID)->first() : null;
	    	$payer = new stdClass();
			if ($customer){
		    	$name = new stdClass();
		    	$name->given_name = ($customer->ContactPersonSurname && $customer->ContactPersonFirstName) ? $customer->ContactPersonFirstName : $customer->Member()->FirstName;
		    	$name->surname = ($customer->ContactPersonSurname && $customer->ContactPersonFirstName) ? $customer->ContactPersonSurname : $customer->Member()->Surname;
		    	$payer->name = $name;
		    	$payer->email_address = ($customer->ContactPersonEmail) ? $customer->ContactPersonEmail : (($customer->CompanyEmail) ? $customer->CompanyEmail : $customer->Member()->Email);
		    	$payer->phone = ($customer->ContactPersonTelephone) ? $customer->ContactPersonTelephone : $customer->Phone;
		    	$address = new stdClass();
		    	if ($customer->BillingAddressIsCompanyAddress){
		    		if ($customer->Address){
			    		$address->address_line_1 = $customer->Address;
			    		$address->postal_code = $customer->PostalCode;
			    		$address->admin_area_2 = $customer->City;
			    		$address->country_code = strtoupper($customer->Country);
			    		$payer->address = $address;
			    	}
		    	}
		    	else{
		    		if ($customer->BillingAddressStreet){
			    		$address->address_line_1 = $customer->BillingAddressStreet;
			    		$address->postal_code = $customer->BillingAddressPostalCode;
			    		$address->admin_area_2 = $customer->BillingAddressPlace;
			    		$address->country_code = strtoupper($customer->BillingAddressCountry);
			    		$payer->address = $address;
			    	}
		    	}
		    }
		    else{
		    	$payer->email_address = $data->email;
		    }

	        return array(
	            'intent' => 'CAPTURE',
	            'purchase_units' =>
	                array(
	                    0 =>
	                        array(
	                            'amount' =>
	                                array(
	                                    'value' => $data->amount,
	                                    'currency_code' => 'EUR',
	                                )
	                        )
	                ),
	            'payer' => $payer

	        );
		    
    		
    	}

    	return [];
    	
    }

   

	public function CreateTransaction(HTTPRequest $request){
		
		$data = json_decode($request->getBody());
		
		$amount = $data->amount;
		if ($amount){
			$OrderRequest = new OrdersCreateRequest();
		    $OrderRequest->prefer('return=representation');
		    $OrderRequest->body = self::buildRequestBody($data);
		    // 3. Call PayPal to set up a transaction
		    $client = PayPalClient::client();
		    $response = $client->execute($OrderRequest);

		    $debug = false;
		    if ($debug)
		    {
		    ob_start();
		     print_r( "Status Code: {$response->statusCode}\n");
		     print_r( "Status: {$response->result->status}\n");
		     print_r("Order ID: {$response->result->id}\n");
		     print_r("Intent: {$response->result->intent}\n");
		     print_r("Links:\n");
		     foreach($response->result->links as $link)
		     {
		       print_r("\t{$link->rel}: {$link->href}\tCall Type: {$link->method}\n");
		     }
		     $result = ob_get_clean();
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-payment.txt", $result);
		     // To print the whole response body, uncomment the following line
		     // echo json_encode($response->result, JSON_PRETTY_PRINT);
		   }
		}
		else{
			$response = ['message' => 'der Betrag fehlt. Bitte laden Sie die Seite wieder und probieren Sie noch ein Mal.'];
		}

	    // 4. Return a successful response to the client.
	    $this->getResponse()->setBody(json_encode($response));

	    $this->getResponse()->addHeader("Content-type", "application/json");

	    return $this->getResponse();

	}


	public function TransactionCompleted(HTTPRequest $request){
		
		$data = $request->postVars();

		$orderId = (isset($data['orderID'])) ? $data['orderID'] : null;
		$cartId = (isset($data['cartID'])) ? $data['cartID'] : null;
		
		if ($orderId && $cartId ){
			
			$client = PayPalClient::client();
			$response = $client->execute(new OrdersGetRequest($orderId));

			
			
			if ($response->statusCode == "200"){
				$cart = ShopCart::get()->byId($cartId);
				if ($cart){
					
					$shipping_address = $response->result->purchase_units[0]->shipping->address;
					//Create and fill the customer
					$customer = (ShopCustomer::get()->filter('Email',$response->result->payer->email_address)->first()) ? ShopCustomer::get()->filter('Email',$response->result->payer->email_address)->first() : new ShopCustomer();
					$duplicateFromCart = ['Name', 'FirstName','Email', 'PostalCode', 'Street', 'Address','Region','City','Country'];
					foreach ($duplicateFromCart as $key => $field) {
						$customer->{$field} = $cart->{$field};
					}
					$customer->DeliveryPostalCode = $shipping_address->postal_code;
					$customer->DeliveryStreet = $shipping_address->address_line_1;
					if (property_exists($shipping_address,'address_line_2')){
						$customer->DeliveryAddress = $shipping_address->address_line_2;
					}
					if (property_exists($shipping_address,'admin_area_1')){
						$customer->DeliveryRegion = $shipping_address->admin_area_1;
					}
					$customer->DeliveryCity = ucfirst(strtolower($shipping_address->admin_area_2));
					$customer->DeliveryCountry = strtolower($shipping_address->country_code);
					$customer->write();

					//Create and fill the order
					$order = new ShopOrder();
					$duplicateFromCart = ['IP', 'TotalPrice','DiscountPrice', 'TransportPrice', 'FullTotalPrice', 'VoucherID','Name', 'FirstName','Email', 'PostalCode', 'Street', 'Address','Region','City','Country'];
					foreach ($duplicateFromCart as $key => $field) {
						$order->{$field} = $cart->{$field};
					}

					$order->DeliveryPostalCode = $shipping_address->postal_code;
					$order->DeliveryStreet = $shipping_address->address_line_1;
					if (property_exists($shipping_address,'address_line_2')){
						$order->DeliveryAddress = $shipping_address->address_line_2;
					}
					if (property_exists($shipping_address,'admin_area_1')){
						$order->DeliveryRegion = $shipping_address->admin_area_1;
					}
					$order->DeliveryCity = ucfirst(strtolower($shipping_address->admin_area_2));
					$order->DeliveryCountry = strtolower($shipping_address->country_code);
					$order->CustomerID = $customer->ID;
					$order->isPaid = true;
					$order->PaymentType = 'creditcard';
					$order->PayPalOrderID = $orderId;

					
					
					try {
						//Write order
						$order->write();

						//Update Voucher
						$order->Voucher()->Used = true;
						$order->Voucher()->Count = $order->Voucher()->count - 1;
						$order->Voucher()->write();
						
						//Add Products
						foreach ($cart->Products() as $p) {
							$item = new OrderItem();
							$item->createFromProduct($p);
							$order->Items()->add($item);
						}
						
						//Send Confirmation Email (BCC to admin)
						$order->sendConfirmationEmail();

						
						//clear cart
						$cart->delete();
						$this->getRequest()->getSession()->clear('shopcart_id');
										
						
						$this->getRequest()->getSession()->set('orderID',$order->ID);

						return json_encode(["status" => 'OK', "redirecturl" => SiteConfig::current_site_config()->SuccessfullPage()->Link()]);
						
					} catch (Exception $e) {
						$validationMessages = '';
						foreach($e->getResult()->getMessages() as $error){
							$validationMessages .= $error['message']."\n";
						}
						return json_encode(["status" => 'NOT OK', 'errors' => $validationMessages ]);
					}
				}
			}
		}
		return json_encode(["status" => 'NOT OK']);
	}


	public function VoucherForm(HTTPRequest $request){
		if ($request->postVar('code')){
			$voucher = Coupon::get()->filter('Code',$request->postVar('code'))->first();
			$id = $this->getRequest()->getSession()->get('shopcart_id');
		    $cart = null;
		    if ($id){
		      $cart = ShopCart::get()->byId($id);
		    }
			if ($voucher && $cart){
				if ($voucher->isValid()){
					$cart->VoucherID = $voucher->ID;
					$cart->write();
					return json_encode([
						'status' => 'OK', 
						'message' => '<p>Ihre Gutschein ist gültig. <br/>Auf Ihre Bestellung wird ein Rabatt von '.$voucher->NiceAmount().' gewährt.</p>', 
						'NiceAmount' => $voucher->NiceAmount()->getValue(),
						'voucherID' => $voucher->ID
					]);
				}
				else{
					return json_encode([
						'status' => 'Not OK', 
						'message' => '<p>Ihre Gutschein ist ungültig.</p>'
					]);
				}
			}
		}
		return json_encode(['status' => 'Not OK','message' => '<p>Ihre Gutschein ist ungültig.</p>']);
	}
}