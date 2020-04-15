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

	public function activeDate(){
		$id = $this->getRequest()->getSession()->get('eventdate_id');
		return EventDate::get()->byId($id);
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
					$this->getRequest()->getSession()->set('eventdate_id',$date->ID);
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
						CheckboxField::create('AGB',DBHTMLText::create()->setValue(_t(__CLASS__.'.AGB','* Hiermit bestätige ich, dass ich sowohl die <a href="{link}" target="_blank">Datenschutzerklärung</a> wie auch die <a href="{link2}" target="_blank">AGB</a> gelesen habe und mit beiden einverstanden bin.', ['link' => $ppLink, 'link2' => '/agb'])))->setAttribute('class','uk-checkbox'),
						NocaptchaField::create('Captcha')
						
					)->setName('SummaryFields'),
					HiddenField::create('PaymentType'),
					HiddenField::create('DateID')->setValue($dateid)
				),
				new FieldList(
					FormAction::create('doRegisterBill', _t('MemberProfiles.REGISTER', 'Jetzt kostenplichtig anmelden'))->setUseButtonTag(true)->addExtraClass('uk-button button-gruen')
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
				

				return $this->redirect('seminare/anmeldung-gespeichert');

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
		if ($request->postVar('voucher') && $request->postVar('event')){
			$voucher = EventCoupon::get()->filter('Token',$request->postVar('voucher'))->first();
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

}