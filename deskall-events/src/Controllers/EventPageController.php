<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\EmailField;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ValidationException;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use SilverStripe\SiteConfig\SiteConfig;
use UndefinedOffset\NoCaptcha\Forms\NocaptchaField;
use SilverStripe\ORM\FieldType\DBHTMLText;


class EventPageController extends PageController{
	private static $allowed_actions = ['OpenEvents','Register','RegisterForm','TransactionCompleted','RegisterSuccessfull', 'VoucherForm'];

	private static $url_handlers = [
		'offene-kurse/$URLSegment' => 'OpenEvents',
		'anmeldung/$URLSegment/$DateID' => 'Register',
		'transaktion-abgeschlossen' => 'TransactionCompleted',
		'anmeldung-bestaetigt' => 'RegisterSuccessfull'
	];

	public function init(){
		parent::init();
	}

	public function OpenEvents(HTTPRequest $request){
		$url = $request->param('URLSegment');
		if ($url){
			$event = Event::get()->filter(['isVisible' => 1, 'URLSegment' => $url])->first();
			if ($event){
				return ['
				Title' => $event->Title, 
				'Event' => $event, 
				'CustomMetaTags' => $event->EventMetaTags(),
				'CustomStructuredData' => $event->EventStructuredData()
				];
			}
		}
		return $this->httpError(404);
	}

	public function Register(HTTPRequest $request){
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		$config = SiteConfig::current_site_config();

		Requirements::javascript("https://www.paypal.com/sdk/js?client-id=".$config->PayPalClientID."&currency=CHF&locale=de_CH");
		Requirements::javascript("deskall-events/javascript/events.js");
		Requirements::javascript("deskall-events/javascript/jquery.validate.min.js");
		Requirements::javascript("deskall-events/javascript/messages_de.min.js");
		$url = $request->param('URLSegment');
		$id = $request->param('DateID');
		if ($url && $id){
			$event = Event::get()->filter(['isVisible' => 1, 'URLSegment' => $url])->first();
			if ($event){
				$date = $event->Dates()->byId($id);
				if ($date){
					return ['Title' => 'Anmeldung','Event' => $event, 'Date' => $date, 'CustomStructuredData' => $date->EventDateStructuredData()];
				}
			}
		}
		return $this->httpError(404);
	}



	public function RegisterForm(){
		$privacyPolicy = PrivatePolicyPage::get()->first();
		$ppLink = ($privacyPolicy) ? $privacyPolicy->Link() : '/';
		$dateid = $this->getRequest()->param('DateID');
		
			$form = new Form(
				$this,
				'RegisterForm',
				new FieldList(
					CompositeField::create(
						DropdownField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau'])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Bitte wählen')),
						TextField::create('Name','Name'),
						TextField::create('Vorname','Vorname'),
						EmailField::create('Email','Email'),
						TextField::create('Company','Firma'),
						TextField::create('Address','Adresse'),
						TextField::create('PostalCode','PLZ'),
						TextField::create('City','Stadt'),
						DropdownField::create('Country','Land')->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('ch')
					)->setName('CustomerFields'),
					CompositeField::create(
						// TextareaField::create('Comments','Bemerkungen'),
						CheckboxField::create('AGB',DBHTMLText::create()->setValue(_t(__CLASS__.'.AGB','Hiermit bestätige ich, dass ich sowohl die <a href="{link}" target="_blank">Datenschutzerklärung</a> wie auch die <a href="{link2}" target="_blank">AGB</a> gelesen habe und mit beiden einverstanden bin. *', ['link' => $ppLink, 'link2' => '/agb'])))->setAttribute('class','uk-checkbox'),
						NocaptchaField::create('Captcha')
						
					)->setName('SummaryFields'),
					HiddenField::create('PaymentType'),
					HiddenField::create('DateID')->setValue($dateid)
				),
				new FieldList(
					FormAction::create('doRegisterBill', _t('MemberProfiles.REGISTER', 'Jetzt kostenplichtig registrieren'))->setUseButtonTag(true)->addExtraClass('uk-button button-gruen')
				),
				RequiredFields::create(['Gender','Name','Vorname','Email','Address','PostalCode','City','Country'])
			);

			$form->addExtraClass('uk-form-horizontal form-std');
			if(is_array($this->getRequest()->getSession()->get('RegisterForm'))) {
				$form->loadDataFrom($this->getRequest()->getSession()->get('RegisterForm'));
			}
			$form->setTemplate('Forms/RegisterForm');

		return $form;
		
	}

	public function doRegisterBill($data,$form){

		//Link to date
		if (isset($data['DateID']) && !empty($data['DateID'])){
			$date = EventDate::get()->byId($data['DateID']);
			if ($date){

				//Save Order
				$order = new Order();
				$form->saveInto($order);
				//Check participant
				$participant = Participant::get()->filter('Email',$data['Email'])->first();
				if (!$participant){
					$participant = new Participant();
					$form->saveInto($participant);
					$participant->write();
				}
				$order->DateID = $date->ID;
				$order->ParticipantID = $participant->ID;
				$order->isPaid = false;
				$order->PaymentType = 'bill';

				//Check if voucher
				if (isset($data['voucher']) && !empty($data['voucher'])){
					$voucher = Voucher::get()->byId($data['voucher']);
					if ($voucher){
						$discountPrice = number_format ( $date->Price - ($date->Price * $voucher->Percent/100), 2);
						$order->Price = $discountPrice;
						$order->VoucherID = $voucher->ID;
					}
				}

				try {
					//Write order
					$order->write();
					$date->Participants()->add($participant);
					//Create Bill
					$order->generatePDF();
					//Send Email
					$order->SendEmail();
				} catch (ValidationException $e) {
					$validationMessages = '';
					foreach($e->getResult()->getMessages() as $error){
						$validationMessages .= $error['message']."\n";
					}
					$form->sessionMessage($validationMessages, 'bad');
					return $this->redirectBack();
				}
				

				return $this->redirect('kurse/anmeldung-gespeichert');

			}
		
		}

		return $this->httpError(404);
		
	}

	public function TransactionCompleted(HTTPRequest $request){
		
		$data = $request->postVars();

		
		$orderId = (isset($data['orderID'])) ? $data['orderID'] : null;
		$dateId = (isset($data['dateID'])) ? $data['dateID'] : null;
		$voucherID = (isset($data['voucherID'])) ? $data['voucherID'] : null; 

		if ($orderId && $dateId){
			//fetch the date
			$date = EventDate::get()->byId($dateId);
			if ($date){
				$client = PayPalClient::client();
				$response = $client->execute(new OrdersGetRequest($orderId));
			
				if ($response->statusCode == "200"){

					//Create and fill the order
					$order = new Order();
					if ($voucherID && $voucherID != ""){
						$voucher = Voucher::get()->byId($voucherID);
						if ($voucher){
							$discountPrice = number_format ( $date->Price - ($date->Price * $voucher->Percent/100), 2);
							$order->Price = $discountPrice;
							$order->VoucherID = $voucher->ID;
						}
					}
					else{
						$order->Price = $date->Price;
					}
					
					$order->Name = ucfirst(strtolower($response->result->payer->name->surname));
					$order->Vorname = ucfirst(strtolower($response->result->payer->name->given_name));
					$order->Email = $response->result->payer->email_address;
					
					$address = $response->result->purchase_units[0]->shipping->address;
					$order->PostalCode = $address->postal_code;
					$order->Address = $address->address_line_1;
					$order->City = ucfirst(strtolower($address->admin_area_2));
					$order->Country = strtolower($address->country_code);

					//Participant
					$participant = Participant::get()->filter('Email',$response->result->payer->email_address)->first();
					if (!$participant){
						$participant = new Participant();
						$participant->Name = ucfirst(strtolower($response->result->payer->name->surname));
						$participant->Vorname = ucfirst(strtolower($response->result->payer->name->given_name));
						$participant->Email = $response->result->payer->email_address;
						$participant->PostalCode = $address->postal_code;
						$participant->Address = $address->address_line_1;
						$participant->City = ucfirst(strtolower($address->admin_area_2));
						$participant->Country = strtolower($address->country_code);
						$participant->write();
					}
					$order->DateID = $date->ID;
					$order->ParticipantID = $participant->ID;
					$order->isPaid = true;
					$order->PaymentType = 'creditcard';
					$order->OrderID = $orderId;

					//Write order
					$order->write();
					$date->Participants()->add($participant,['paid' => 1]);
					//Create Receipt
					$order->generateQuittungPDF();
					//Send Confirmation Email
					$order->SendConfirmationEmail();

					$this->getRequest()->getSession()->set('orderID',$order->ID);

					return json_encode(["status" => 'OK']);
				}
				
			}
		}
		return json_encode(["status" => 'NOT OK']);
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

	public function RegisterSuccessfull(HTTPRequest $request){
		
		$orderID = $request->getSession()->get('orderID');
		if ($orderID){
			$order = Order::get()->byId($orderID);
			if ($order){
				return ['Title' => 'Anmeldung bestätigt', 'Order' => $order, 'Event' => $order->Date()->Event(), 'Date' => $order->Date()];
			}
		}

		return $this->httpError(404);
	}

	public function VoucherForm(HTTPRequest $request){
		if ($request->postVar('code')){
			$voucher = Coupon::get()->filter('Code',$request->postVar('code'))->first();
			$id = $this->getRequest()->getSession()->get('eventcart_id');
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