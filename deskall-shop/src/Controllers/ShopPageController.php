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

	public function CheckoutForm(){
		$member =  Security::getCurrentUser();
		$customer = JobGiver::get()->filter('MemberID',$member->ID)->first();

		Requirements::javascript("https://www.paypal.com/sdk/js?client-id=".SiteConfig::current_site_config()->PayPalClientID."&currency=EUR&locale=de_DE");
		Requirements::javascript("deskall-shop/javascript/shop.js");
		Requirements::javascript("deskall-shop/javascript/jquery.validate.min.js");
		Requirements::javascript("deskall-shop/javascript/messages_de.min.js");
		$fields = FieldList::create(
			HiddenField::create('ProductID'),
			HiddenField::create('OptionID'),
			HiddenField::create('PaymentType'),
			HiddenField::create('CustomerID')->setValue($customer->ID),
			HiddenField::create('VoucherID'),
			CompositeField::create(
				TextField::create('BillingAddressCompany',_t(__CLASS__.'.BillingAddressCompany','Firma')),
				TextField::create('BillingAddressStreet',_t(__CLASS__.'.BillingAddressStreet','Adresse')),
				TextField::create('BillingAddressPostalCode',_t(__CLASS__.'.BillingAddressPostalCode','PLZ')),
				TextField::create('BillingAddressPlace',_t(__CLASS__.'.BillingAddressPlace','Ort')),
				DropdownField::create('BillingAddressCountry',_t(__CLASS__.'.BillingAddressCountry','Land'))->setSource(i18n::getData()->getCountries())->setValue('de')->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))
			)->setName('BillFields'),
			CompositeField::create(
				// TextareaField::create('Comments','Bemerkungen'),
				CheckboxField::create('AGB',DBHTMLText::create()->setValue(_t(__CLASS__.'.AGB','Hiermit bestätige ich, dass ich sowohl die <a href="{link}" target="_blank">Datenschutzerklärung</a> wie auch die <a href="{link2}" target="_blank">AGB</a> gelesen habe und mit beiden einverstanden bin. *', ['link' => PrivatePolicyPage::get()->first()->Link(), 'link2' => '/agb'])))->setAttribute('class','uk-checkbox'),
				NocaptchaField::create('Captcha')
				
			)->setName('SummaryFields')
		);
		$actions = new FieldList(FormAction::create('payBill', _t('SHOP.BUY', 'Jetzt kaufen'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="uk-margin-small-right" data-uk-icon="cart"></i>'._t('SHOP.BUY', 'Jetzt kaufen')));
		$required = RequiredFields::create(['BillingAddressCompany','BillingAddressStreet','BillingAddressPostalCode','BillingAddressPlace','BillingAddressCountry','AGB']);

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
		$fields = $form->Fields();
		if ($customer->BillingAddressIsCompanyAddress){
			$fields->dataFieldByName('BillingAddressCompany')->setValue($customer->Company);
			$fields->dataFieldByName('BillingAddressStreet')->setValue($customer->Address);
			$fields->dataFieldByName('BillingAddressPostalCode')->setValue($customer->PostalCode);
			$fields->dataFieldByName('BillingAddressPlace')->setValue($customer->City);
			$fields->dataFieldByName('BillingAddressCountry')->setValue($customer->Country);
		}
		else{
			$fields->dataFieldByName('BillingAddressCompany')->setValue($customer->BillingAddressCompany);
			$fields->dataFieldByName('BillingAddressStreet')->setValue($customer->BillingAddressStreet);
			$fields->dataFieldByName('BillingAddressPostalCode')->setValue($customer->BillingAddressPostalCode);
			$fields->dataFieldByName('BillingAddressPlace')->setValue($customer->BillingAddressPlace);
			$fields->dataFieldByName('BillingAddressCountry')->setValue($customer->BillingAddressCountry);
		}

		return $form;
	}


	public function payBill($data,$form){
		//retrieve customer
		if (isset($data['CustomerID']) && !empty($data['CustomerID'])){
			$customer = JobGiver::get()->byId($data['CustomerID']);
			if ($customer){
				//Link to package
				if (isset($data['ProductID']) && !empty($data['ProductID'])){
					$package = Package::get()->byId($data['ProductID']);
					if ($package){
						$form->saveInto($customer);
						//Option if any
						$packageOption = null;
						if (isset($data['OptionID']) && !empty($data['OptionID'])){
							$packageOption = PackageOption::get()->byId($data['OptionID']);
							
						}
						//Create and fill the order
							$order = new ShopOrder();
							$form->saveInto($order);
							$order->Price = ($packageOption) ? $packageOption->currentPrice() : $package->currentPrice();
							$order->isPaid = false;
							$order->Name = $customer->ContactPersonSurname;
							$order->Vorname = $customer->ContactPersonFirstName;
							$order->Email = $customer->CompanyEmail;
							$order->Address = $customer->BillingAddressStreet;
							$order->PostalCode = $customer->BillingAddressPostalCode;
							$order->City = $customer->BillingAddressPlace;
							$order->Country = $customer->BillingAddressCountry;
							$order->Phone = $customer->ContactPersonTelephone;



							try {
								//Write order
								$order->write();
								//Write customer
								$customer->write();

								//Create Receipt
								$order->generatePDF();
								//Send Confirmation Email (BCC to admin)
								$order->sendEmail();
								

								$this->getRequest()->getSession()->set('orderID',$order->ID);
								
								return $this->Redirect('danke-fuer-ihre-bestellung');
								
							} catch (ValidationException $e) {
								$validationMessages = '';
								foreach($e->getResult()->getMessages() as $error){
									$validationMessages .= $error['message']."\n";
								}
								$form->sessionMessage($validationMessages, 'bad');
								return $this->redirectBack();
							}
						
						

					}
				
				}
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
		$productId = (isset($data['productID'])) ? $data['productID'] : null;
		
		if ($orderId && $productId ){
			
			$client = PayPalClient::client();
			$response = $client->execute(new OrdersGetRequest($orderId));
			
			if ($response->statusCode == "200"){
				$package = Package::get()->byId($productId);
				$member = Security::getCurrentUser();
				$customer  = ($member) ? JobGiver::get()->filter('MemberID',$member->ID)->first() : null;
				if ($package && $customer){
					//Create and fill the order
						$order = new ShopOrder();
						$order->ProductID = $package->ID;
						$order->Name = ucfirst(strtolower($response->result->payer->name->surname));
						$order->Vorname = ucfirst(strtolower($response->result->payer->name->given_name));
						$order->Email = $response->result->payer->email_address;
						$order->Price = $package->currentPrice();
						$address = $response->result->purchase_units[0]->shipping->address;
						$order->PostalCode = $address->postal_code;
						$order->Address = $address->address_line_1;
						$order->City = ucfirst(strtolower($address->admin_area_2));
						$order->Country = strtolower($address->country_code);
						$order->CustomerID = $customer->ID;
						$order->isPaid = true;
						$order->PaymentType = 'creditcard';
						$order->PayPalOrderID = $orderId;

						//Voucher 
						if (isset($data['voucherID']) && $voucher = Coupon::get()->byId($data['voucherID'])){
							$order->VoucherID = $voucher->ID;
						}
						
						try {
							//Write order
							$order->write();
							//Create Receipt
							$order->generateQuittungPDF();
							//Send Confirmation Email (BCC to admin)
							$order->sendConfirmationEmail();
							
							$this->getRequest()->getSession()->set('orderID',$order->ID);

							return json_encode(["status" => 'OK']);
							
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
		if ($request->postVar('code') && $request->postVar('package')){
			$voucher = Coupon::get()->filter('Code',$request->postVar('code'))->first();
			$package = Package::get()->byId($request->postVar('package'));
			if ($voucher && $package){
				if ($voucher->isValid()){
					$originalPrice = $package->currentPrice();
					$discountPrice = $voucher->DiscountPrice($originalPrice);

					return json_encode([
						'status' => 'OK', 
						'message' => '<p>Ihre Gutschein ist gültig. <br/>Auf Ihre Bestellung wird ein Rabatt von '.$voucher->NiceAmount().' gewährt.</p>', 
						'price' => $discountPrice,
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