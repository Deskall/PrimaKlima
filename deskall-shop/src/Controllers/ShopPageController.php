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

class ShopPageController extends PageController{
	private static $allowed_actions = ['ProductDetails','CategoryDetails','CreateTransaction','TransactionCompleted','Checkout','BuyBillForm','PaymentSuccessfull','CustomerForm','CustomerAccount','OnlineDelivery','CertificateForm','DownloadCertificat','VideoSeen','OrderLoginForm', 'CheckoutForm'];

	private static $url_handlers = [
		'produkte/$URLSegment' => 'ProductDetails',
		'kategorien/$URLSegment' => 'CategoryDetails',
		'transaktion-erstellen' => 'CreateTransaction',
		'transaktion-abgeschlossen' => 'TransactionCompleted',
		'kaufen/$URLSegment' => 'Checkout',
		'bestellung-bestaetigt' => 'PaymentSuccessfull',
		'mein-konto' => 'CustomerAccount',
		'online-lieferung/$OrderID' => 'OnlineDelivery',
		'zertifikat/$OrderID' => 'DownloadCertificat',
		'video-fertig/$OrderID' => 'VideoSeen'
	];

	public function init(){
		parent::init();
		
	}

	public function CheckoutForm(){
		Requirements::javascript("https://www.paypal.com/sdk/js?client-id=".SiteConfig::current_site_config()->PayPalClientID."&currency=EUR&locale=de_DE");
		Requirements::javascript("deskall-shop/javascript/shop.js");
		Requirements::javascript("deskall-shop/javascript/jquery.validate.min.js");
		Requirements::javascript("deskall-shop/javascript/messages_de.min.js");
		$fields = FieldList::create(
			HiddenField::create('PackageID'),
			HiddenField::create('PackageOptionID'),
			HiddenField::create('PaymentType'),
			CompositeField::create(
				TextField::create('BillingAddressCompany',_t(__CLASS__.'.BillingAddressCompany','Firma')),
				TextField::create('BillingAddressStreet',_t(__CLASS__.'.BillingAddressStreet','Adresse')),
				TextField::create('BillingAddressPostalCode',_t(__CLASS__.'.BillingAddressPostalCode','PLZ')),
				TextField::create('BillingAddressPlace',_t(__CLASS__.'.BillingAddressPlace','Ort')),
				DropdownField::create('BillingAddressCountry',_t(__CLASS__.'.BillingAddressCountry','Land'))->setSource(i18n::getData()->getCountries())->setValue('de')->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))
			)->setName('BillFields'),
			CompositeField::create(
				CheckboxField::create('AGB','AGB'),
				TextareaField::create('Comments','Bemerkungen')
			)->setName('SummaryFields')

		);
		$actions = new FieldList(FormAction::create('payBill', _t('SHOP.BUY', 'Jetzt kaufen'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-cart uk-margin-small-right"></i>'._t('SHOP.BUY', 'Jetzt kaufen')));
		$required = RequiredFields::create([]);

		$form = new Form(
			$this,
			'CheckoutForm',
			$fields,
			$actions,
			$required
		);
		
		$form->setTemplate('Forms/CheckoutForm');
		$form->addExtraClass('uk-form-horizontal form-std');
		// $form->loadDataFrom($JobGiver);

		return $form;
	}

	public function ProductDetails(HTTPRequest $request){
		$url = $request->param('URLSegment');
		if ($url){
			$product = Product::get()->filter(['isVisible' => 1, 'URLSegment' => $url])->first();
			if ($product){
				return [
					'Title' => $product->Title, 
					'Product' => $product, 
					'CustomMetaTags' => $product->MetaTags(),
					'CustomStructuredData' => $product->StructuredData(),
					'URLSegment' => $url
				];
			}
		}
		return $this->httpError(404);
	}

	public function OnlineDelivery(HTTPRequest $request){
		$customer = Security::getCurrentUser();
		
		if ($customer){
			$id = $request->param('OrderID');
			if ($id){
				$order = ShopOrder::get()->byId($id);
				if ($order){
					if ($customer->ID != $order->Customer->MemberID){
						return Security::permissionFailure($this, _t(
											'MemberProfiles.AccessDenied',
											'Sie dürfen diesen Bereich nicht betreten.'
										));
					}
					//we check that we have all the required data for certificate
					$form = null;
					if ($order->Product()->WithCertification){
						$extrarequired = false;
						
						if (!$order->Customer()->Birthday){
							$extrarequired = true;
						}
						if (!$order->Customer()->BirthPlace){
							$extrarequired = true;
						}
					}
					return [
						'Title' => 'Ihre Produkt: '.$order->Product()->Title, 
						'Product' => $order->Product(),
						'Order' => $order,
						'missingData' => $extrarequired
					];
				}
			}
			return $this->httpError(404);
		}
	}


	public function VideoSeen(HTTPRequest $request){
		$id = $request->param('OrderID');
		if ($id){
			$order = ShopOrder::get()->byId($id);
			if ($order){
				$order->wasSeen = true;
				$order->write();
				$this->getResponse()->setStatusCode(200);
    			return $this->getResponse();
			}
		}
		return $this->httpError(404);
	}

	public function CertificateForm(){
		$member = Security::getCurrentUser();
		if ($member){
			$customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
			if ($customer){
				$fields = FieldList::create();
				$required = [];
				if (!$customer->Birthday){
					$fields->push(DateField::create('Birthday',$customer->fieldLabels()['Birthday'])->setAttribute('class','uk-input uk-width-large'));
					$required[] = 'Birthday';
				}
				if (!$customer->BirthPlace){
					$fields->push(TextField::create('BirthPlace',$customer->fieldLabels()['BirthPlace'])->setAttribute('class','uk-input uk-width-large'));
					$required[] = 'BirthPlace';
				}
				$form = new Form(
					$this,
					'CertificateForm',
					$fields,
					new FieldList(
						FormAction::create('doSaveForCertificate', _t('ShopCustomer.SaveForCertificate', 'Profil aktualisieren und Zertifikat herunterladen'))->addExtraClass('uk-button PrimaryBackground')
					),
					RequiredFields::create($required)
				);

				return $form;
			}
		}
		
		return null;
	}

	public function doSaveForCertificate($data,$form){
		$member = Security::getCurrentUser();
		if ($member){
			$customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
			if ($customer){

				$form->saveInto($customer);
				try {
					//Write customer
					$customer->write();
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
		

		return Security::permissionFailure($this, _t(
							'MemberProfiles.NeedToLogin',
							'Sie müssen sich anmelden, um auf diese Seite zugreifen zu können'
						));
		
	}

	public function CategoryDetails(HTTPRequest $request){
		$url = $request->param('URLSegment');
		if ($url){
			$category = ProductCategory::get()->filter(['isVisible' => 1, 'URLSegment' => $url])->first();
			if ($category){
				return [
					'Title' => $category->Title, 
					'Category' => $category, 
					'CustomMetaTags' => $category->MetaTags(),
					'CustomStructuredData' => $category->StructuredData(),
					'URLSegment' => $url
				];
			}
		}
		return $this->httpError(404);
	}

	public function Checkout(HTTPRequest $request){
		$config = SiteConfig::current_site_config();
		$url = $request->param('URLSegment');
		if ($url){
			$product = Product::get()->filter(['isVisible' => 1, 'URLSegment' => $url])->first();
			if ($product){
				$request->getSession()->set('ProductID',$product->ID);
				$member = Security::getCurrentUser();
				if ($member){
					$customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
					if ($customer &&  $member->inGroup('shop-kunden')){
						$request->getSession()->set('CustomerID',$member->ID);
					}
				}
				
				Requirements::javascript("https://www.paypal.com/sdk/js?client-id=".$config->PayPalClientID."&currency=EUR&locale=de_DE");
				return ['Title' => 'Kaufen','Product' => $product, 'CustomStructuredData' => $product->StructuredData()];
			}
		}
		return $this->httpError(404);
	}

	public function OrderLoginForm() {
	    i18n::set_locale('de_DE');
	 
	    $form = MemberLoginForm::create($this,'MemberAuthenticator','LoginForm');
	    
	    $form->Fields()->FieldByName('Email');
	    $form->Fields()->FieldByName('Password');
	    $form->Fields()->removeByName('Remember');
	    $form->Actions()->FieldByName('action_doLogin')->setUseButtonTag(true)->addExtraClass('uk-button uk-button-primary uk-align-right');
	    $form->addExtraClass('uk-form-horizontal');
	    $form->setTemplate('OrderLoginForm');

	    $form->Fields()->push(HiddenField::create('BackURL', 'BackURL', $this->getRequest()->getURL()));
	    
	    return $form;
	}




	public function BuyBillForm(){
		$form = new Form(
			$this,
			'BuyBillForm',
			new FieldList(
				DropdownField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau'])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Bitte wählen')),
				TextField::create('Name','Name'),
				TextField::create('Vorname','Vorname'),
				HiddenField::create('Email','Email'),
				TextField::create('Company','Firma'),
				TextField::create('Address','Adresse'),
				TextField::create('PostalCode','PLZ'),
				TextField::create('City','Stadt'),
				DropdownField::create('Country','Land')->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')),
				TextField::create('UIDNumber','UID-Nr.'),
				HiddenField::create('ProductID')->setValue($this->getRequest()->getSession()->get('ProductID')),
				HiddenField::create('Quantity')->setValue(1)
			),
			new FieldList(
				FormAction::create('doBuyBill', _t('SHOP.BUYNOW', 'Jetzt kaufen'))->addExtraClass('uk-button PrimaryBackground')
			),
			RequiredFields::create(['Gender','Name','Vorname','Address','PostalCode','City','Country'])
		);
		$member = Security::getCurrentUser();
		if ($member){
			$customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
			if ($customer){
				$form->loadDataFrom($customer);
				$form->Fields()->fieldByName('Name')->setValue($member->Surname);
				$form->Fields()->fieldByName('Vorname')->setValue($member->FirstName);
			}
		}

		$form->addExtraClass('uk-form-horizontal form-std');
		if(is_array($this->getRequest()->getSession()->get('BuyBillForm'))) {
			$form->loadDataFrom($this->getRequest()->getSession()->get('BuyBillForm'));
		}
		return $form;
	}

	public function doBuyBill($data,$form){

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

	private static function buildRequestBody($data)
    {
    	//1. Amount, if not we return null
    	
    	if ($data->amount && $data->email){
    		//2. Customer
    		$member = (Security::getCurrentUser()) ? Security::getCurrentUser() : Member::get()->filter('Email',$data->email)->first();
    		$customer = ($member) ? ShopCustomer::get()->filter('MemberID',$member->ID)->first() : null;
	    	$payer = new stdClass();
			if ($customer){
		    	$name = new stdClass();
		    	$name->given_name = $customer->Member()->FirstName;
		    	$name->surname = $customer->Member()->Surname;
		    	$payer->name = $name;
		    	$payer->email_address = $customer->Member()->Email;
		    	$payer->birth_date = $customer->Birthday;
		    	$payer->phone = $customer->Phone;
		    	$address = new stdClass();
		    	if ($customer->Address){
		    		$address->address_line_1 = $customer->Address;
		    		$address->postal_code = $customer->PostalCode;
		    		$address->admin_area_2 = $customer->City;
		    		$address->country_code = strtoupper($customer->Country);
		    		$payer->address = $address;
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

		    $debug = true;
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
		$quantity = (isset($data['quantity'])) ? $data['quantity'] : 1;
		if ($orderId && $productId ){
			
			$client = PayPalClient::client();
			$response = $client->execute(new OrdersGetRequest($orderId));
			
			if ($response->statusCode == "200"){
				$product = Product::get()->byId($productId);
				if ($product){
					//Create and fill the order
					$order = new ShopOrder();
					$order->Price = $response->result->purchase_units[0]->amount->value;
					$order->Quantity = $quantity;
					$order->ProductID = $productId;

					$address = $response->result->purchase_units[0]->shipping->address;
					
					//Customer
					$member = (Security::getCurrentUser()) ? Security::getCurrentUser() : Member::get()->filter('Email',$data['email'])->first();
					$isMember = true;
					if (!$member){
						$isMember = false;
						$member = new Member();
						$member->Surname = ucfirst(strtolower($response->result->payer->name->surname));
						$member->FirstName = ucfirst(strtolower($response->result->payer->name->given_name));
						$member->Email = $data['email'];
						$member->write();
					}
    				$customer = ($member) ? ShopCustomer::get()->filter('MemberID',$member->ID)->first() : null;
					if (!$customer){
						$customer = new ShopCustomer();
						$customer->PostalCode = $address->postal_code;
						$customer->Address = $address->address_line_1;
						$customer->City = ucfirst(strtolower($address->admin_area_2));
						$customer->Country = strtolower($address->country_code);
						$customer->MemberID = $member->ID;
						$customer->write();
						
					}
					if (!$isMember){
						$customer->sendLoginData();
					}
					$order->Name = ucfirst(strtolower($response->result->payer->name->surname));
					$order->Vorname = ucfirst(strtolower($response->result->payer->name->given_name));
					$order->Email = $data['email'];
					
					
					$order->PostalCode = $address->postal_code;
					$order->Address = $address->address_line_1;
					$order->City = ucfirst(strtolower($address->admin_area_2));
					$order->Country = strtolower($address->country_code);

					$order->CustomerID = $customer->ID;
					$member->addToGroupByCode('shop-kunden');
					$order->isPaid = true;
					$order->PaymentType = 'creditcard';
					$order->OrderID = $orderId;
					$identityStore = Injector::inst()->get(IdentityStore::class);
					$identityStore->logIn($member, false, $request);

					//Write order
					$order->write();
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

	public function PaymentSuccessfull(HTTPRequest $request){
		$member = Security::getCurrentUser();
		if ($member){
			$orderID = $request->getSession()->get('orderID');
			if ($orderID){
				$order = ShopOrder::get()->byId($orderID);
				if ($order){
					return ['Title' => 'Ihre Bestellung wird bestätigt', 'Order' => $order, 'Product' => $order->Product()];
				}
			}
			return $this->httpError(404);
		}
		return Security::permissionFailure($this, _t(
							'MemberProfiles.NeedToLogin',
							'Sie müssen sich anmelden, um auf diese Seite zugreifen zu können'
						));
	}

	public function VoucherForm(HTTPRequest $request){
		if ($request->postVar('voucher') && $request->postVar('event')){
			$voucher = Voucher::get()->filter('Token',$request->postVar('voucher'))->first();
			$event = EventDate::get()->byId($request->postVar('event'));
			if ($voucher && $event){
				if ($voucher->isValid()){
					$originalPrice = $event->Price;
					$discountPrice = number_format ( $event->Price - ($event->Price*$voucher->Percent/100), 2);
					return json_encode([
						'status' => 'OK', 
						'message' => '<p>Ihre Gutschein ist gültig. <br/>Auf Ihre Bestellung wird ein Rabatt von '.$voucher->Percent.'% gewährt.</p>', 
						'price' => $discountPrice,
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
		return json_encode(['status' => 'Not found']);
	}

	public function CustomerAccount(HTTPRequest $request){
		$member = Security::getCurrentUser();
		if (!$member){
			return Security::permissionFailure($this, _t(
				'MemberProfiles.NeedToLogin',
				'Sie müssen sich anmelden, um auf diese Seite zugreifen zu können'
			));
		}

		if (!Security::getCurrentUser()->inGroup('shop-kunden')){
			return Security::permissionFailure($this, _t(
				'MemberProfiles.NoAccess',
				'Sie haben nicht die erforderlichen Rechte, um auf diese Seite zuzugreifen'
			));
		}

		$customer = ShopCustomer::get()->filter('MemberID',$member->ID)->first();
		if (!$customer){
			return Security::permissionFailure($this, _t(
				'MemberProfiles.NoAccess',
				'Sie haben nicht die erforderlichen Rechte, um auf diese Seite zuzugreifen'
			));
		}

		return ['Title' => _t('Shop.MyAccount','Mein Konto'),'isAccount' => true, 'Orders' => $customer->Orders() ];
	}


	public function CustomerForm(){
		
		$member = Security::getCurrentUser();
		$customer = ($member) ? ShopCustomer::get()->filter('MemberID',$member->ID)->first() : null;
		if ($customer){
				$form = new Form(
					$this,
					'CustomerForm',
					new FieldList(
						DropdownField::create('Gender','Anrede',['Herr' => 'Herr','Frau' => 'Frau'])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Bitte wählen')),
						TextField::create('Surname',$member->fieldLabels()['Surname'])->setValue($member->Surname),
						TextField::create('FirstName',$member->fieldLabels()['FirstName'])->setValue($member->FirstName),
						DateField::create('Birthday',$customer->fieldLabels()['Birthday'])->setAttribute('class','uk-input'),
						TextField::create('BirthPlace',$customer->fieldLabels()['BirthPlace']),
						EmailField::create('Email',$member->fieldLabels()['Email'])->setValue($member->Email),
						TextField::create('Company',$customer->fieldLabels()['Company']),
						TextField::create('Address',$customer->fieldLabels()['Address']),
						TextField::create('PostalCode',$customer->fieldLabels()['PostalCode']),
						TextField::create('City',$customer->fieldLabels()['City']),
						DropdownField::create('Country',$customer->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')),
						TextField::create('UIDNumber',$customer->fieldLabels()['UIDNumber'])
					),
					new FieldList(
						FormAction::create('doUpdateCustomer', _t('MemberProfiles.Update', 'Angaben aktualisieren'))->addExtraClass('uk-button PrimaryBackground')
					),
					RequiredFields::create(['Gender','Surname','FirstName','Email','Birthday','Address','PostalCode','City','Country'])
				);

				$form->loadDataFrom($customer);
				

				$form->addExtraClass('uk-form-horizontal form-std');
				

				return $form;
			}
		
	}

	public function doUpdateCustomer($data,$form){
		$member = Security::getCurrentUser();
		if ($member){
			$customer = ($member) ? ShopCustomer::get()->filter('MemberID',$member->ID)->first() : null;
			if ($customer){
				$form->saveInto($customer);
				$member->Email = $data['Email'];
				$member->Surname = $data['Surname'];
				$member->FirstName = $data['FirstName'];
				try {
					//Write customer
					$member->write();
					$customer->write();
				} catch (ValidationException $e) {
					$validationMessages = '';
					foreach($e->getResult()->getMessages() as $error){
						$validationMessages .= $error['message']."\n";
					}
					$form->sessionMessage($validationMessages, 'bad');
					return $this->redirectBack();
				}
				$form->sessionMessage(
					_t('MemberProfiles.PROFILEUPDATED', 'Ihre Profil wurde aktualisiert.'),
					'good'
				);
		
				return $this->redirectBack();
		
			}
		}
			
		
		return Security::permissionFailure($this, _t(
							'MemberProfiles.NeedToLogin',
							'Sie müssen sich anmelden, um auf diese Seite zugreifen zu können'
						));
		
	}

	public function DownloadCertificat(HTTPRequest $request){
		$member = Security::getCurrentUser();
		if ($member){
			$customer = ($member) ? ShopCustomer::get()->filter('MemberID',$member->ID)->first() : null;
			if ($customer){
				$id = $request->param('OrderID');
				if ($id){
					$order = ShopOrder::get()->byId($id);
					if ($order){
						if ($customer->ID != $order->CustomerID){
							return Security::permissionFailure($this, _t(
												'MemberProfiles.AccessDenied',
												'Sie dürfen diesen Bereich nicht betreten.'
											));
						}
						if (!$order->CertificatFile()->exists()){
							$order->generateCertificat();
						}
						$file = $order->CertificatFile();

						return $this->redirect($file->Link());
					}
				}
				return $this->httpError(404);
			}
		}
		
		return Security::permissionFailure($this, _t(
							'MemberProfiles.NeedToLogin',
							'Sie müssen sich anmelden, um auf diese Seite zugreifen zu können'
						));
	}

}