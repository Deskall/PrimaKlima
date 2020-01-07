<?php

use SilverStripe\View\ArrayData;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\SSViewer;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\ValidationException;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\DateField;
class CoursePageController extends Extension
{
   private static $allowed_actions = ['kursDetails','SendKurseForm'];

	private static $url_handlers = [
	    'kurs-details/$ID' => 'kursDetails'
	];

	public function kursDetails(HTTPRequest $request){
		$KursID = $request->param('ID');
		if ($KursID){
      		$Api = new beyond_jsonKurse();
     		$data = $Api->getKurse(null,$KursID);
     		if (is_array($data) and isset($data[0])){
     			return array(
     				'kursData' => new ArrayData($data[0]),
     				'Title' => $data[0]->Titel
     			);
     		}
    }
        return $this->owner->httpError(404);
	}

    public function SendKurseForm(){

        $actions = new FieldList(FormAction::create('doRegister', _t('CourseRegistration.Register', 'Jetzt anmelden'))->addExtraClass('uk-button PrimaryBackground')->setUseButtonTag(true)->setButtonContent('<i class="icon icon-checkmark uk-margin-small-right"></i>'._t('CourseRegistration.Register', 'Jetzt anmelden')));

        $fields = FieldList::create(
            DropdownField::create('anrede','Anrede',['Herr' => 'Herr','Frau' => 'Frau']),
            TextField::create('name','Name'),
            TextField::create('vorname','Vorname'),
            EmailField::create('email','E-Mail-Adresse'),
            DateField::create('birthday','Geburstdatum'),
            TextField::create('strasse','Strasse'),
            TextField::create('plz','PLZ'),
            TextField::create('ort','Ort'),
            TextField::create('telephone','Telefon')
        );

        $requiredFields = new RequiredFields(['anrede','name','vorname','email','birthday']);
        
        $form = new Form(
            $this,
            'SendKurseForm',
            $fields,
            $actions,
            $requiredFields
        );
        
        // $form->setTemplate('Forms/RegisterForm');
        $form->addExtraClass('form-std');

        return $form;
    }


    public function doRegister($data,$form){

        ob_start();
                    print_r($data);
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);

        
        //Recaptcha validation
        if (!array_key_exists('g-recaptcha-response', $data) || empty($data['g-recaptcha-response'])) {
          return $this->owner->redirectBack();
        }

        $response = $this->recaptchaHTTPPost($data['g-recaptcha-response']);
        $response = json_decode($response, true);
       
       

        if (!$response['success']) {
          return $this->owner->redirectBack();
        }
        if (isset($data['course'])){
            $Api = new beyond_jsonKurse();
            $course = $Api->getKurse(null,$data['course']);

            if (is_array($course) and isset($course[0])){
                $course = $course[0];
               
                   //Course Data
                    $courseData = '<h3>Kurs Informationen</h3><table>'.
                    '<tr><td>Titel</td><td>'.$course->Titel.'</td></tr>'.
                    '<tr><td>Kurs-Nr.</td><td>'.$course->KursID.'</td></tr>'.
                    '<tr><td>Datum</td><td>'.$course->DatumVonDatumBis.'</td></tr>'.
                    '<tr><td>Tag</td><td>'.$course->WochentagLang.'</td></tr>'.
                    '<tr><td>Zeit</td><td>'.$course->ZeitVonZeitBis.'</td></tr>';
                    if ($course->AnzahlLektionen > 0){
                        $courseData .= '<tr><td>Dauer</td><td>'.$course->AnzahlLektionen.' * '.$course->DauerMinuten.' min</td></tr>';
                    }
                    else{
                        $courseData .= '<tr><td>Dauer</td><td>'.$course->DauerMinuten.' min</td></tr>';
                    }

                    $courseData .= '<tr><td>Kosten</td><td>'.$course->PreisPaarPerson.'</td></tr>'.
                    '<tr><td>Kursleitung</td><td>'.$course->LehrerVorname.' '.$course->LehrerNachname.'</td></tr>'.
                    '</table>';

                    //Anmeldung Data
                   $personData = '<br/><br/><h3>Ihre Angaben</h3><table>'.
                   '<tr><td>Anrede</td><td>'.$data['anrede'].'</td></tr>'.
                   '<tr><td>Name</td><td>'.$data['name'].'</td></tr>'.
                   '<tr><td>Vorname</td><td>'.$data['vorname'].'</td></tr>'.
                   '<tr><td>E-Mail-Adresse</td><td>'.$data['email'].'</td></tr>'.
                   '<tr><td>Geburstdatum</td><td>'.$data['birthday'].'</td></tr>'.
                   '<tr><td>Strasse</td><td>'.$data['strasse'].'</td></tr>'.
                   '<tr><td>PLZ / Ort</td><td>'.$data['plz'].' / '.$data['ort'].'</td></tr>'.
                   '<tr><td>Telefon</td><td>'.$data['telephone'].'</td></tr>'.
                   '</table><br/><br/>';

                   $geschlecht1 = ($data['anrede'] == "Frau") ? 'w' : 'm'; 


                   //Registration in BeyonD Tool
                    if ($course->istPaarTanz){
                        $geschlecht2 = ($data['anrede2'] == "Frau") ? 'w' : 'm'; 
                        //  First we check if address exists
                       $AddressManager = new beyond_jsonAdressen();
                       
                       $address1 = $AddressManager->getAdressen(null,null,null,$data['vorname'],$data['name'],null,$data['email']);
                       if (empty($address1)){
                        //add address
                        $address1 = $AddressManager->addAdresse($AdressenRowguid = null,$PostRowguid = null,$VaterRowguid = null,$MutterRowguid = null,$Geschlecht = $geschlecht1,$Titel = null,$AnredeForm = null,$RechnungsArt = null,$Vorname = $data['vorname'],$Nachname = $data['name'],$TelefaxP = null,$TelefonP = $data['telephone'],$TelefonP2 = null,$TelefonG = null,$TelefaxG = null,$TelefonG2 = null,$TelefonN = null,$EMail1 = $data['email'],$EMail1Werbung = null,$EMail2 = null,$EMail2Werbung = null,$EMail3 = null,$EMail3Werbung = null,$OrtP = $data['ort'],$KantonP = null,$LandP = null,$PLZP = $data['plz'],$StrasseP = $data['strasse'],$Grösse = null,$GrösseAnzeigen = null,$Geburtsdatum = $data['birthday'],$GeburtsdatumAnzeigen = null,$AufmerksamDurch = null,$ErstellungVon = null,$ErstellungsDatum = null);
                        $rowId1 = $address1[0];
                       }
                       else{
                        $rowId1 = $address1[0]->rowguid;
                       }

                       $address2 = $AddressManager->getAdressen(null,null,null,$data['vorname2'],$data['name2'],null,$data['email2']);
                       if (empty($address2)){
                        //add address
                        $address2 = $AddressManager->addAdresse($AdressenRowguid = null,$PostRowguid = null,$VaterRowguid = null,$MutterRowguid = null,$Geschlecht = $geschlecht2,$Titel = null,$AnredeForm = null,$RechnungsArt = null,$Vorname = $data['vorname2'],$Nachname = $data['name2'],$TelefaxP = null,$TelefonP = $data['telephone2'],$TelefonP2 = null,$TelefonG = null,$TelefaxG = null,$TelefonG2 = null,$TelefonN = null,$EMail1 = $data['email2'],$EMail1Werbung = null,$EMail2 = null,$EMail2Werbung = null,$EMail3 = null,$EMail3Werbung = null,$OrtP = $data['ort2'],$KantonP = null,$LandP = null,$PLZP = $data['plz2'],$StrasseP = $data['strasse2'],$Grösse = null,$GrösseAnzeigen = null,$Geburtsdatum = $data['birthday2'],$GeburtsdatumAnzeigen = null,$AufmerksamDurch = null,$ErstellungVon = null,$ErstellungsDatum = null);
                        $rowId2 = $address2[0];
                       }
                       else{
                        $rowId2 = $address2[0]->rowguid;
                       }
                       //Proceed registration
                       $register = new beyond_jsonAnmeldungen();
                       $registration = $register->addAnmeldungen($AnmeldungsRowguid = null,$KursID = $course->KursID,$Geschlecht1 = $geschlecht1,$Geschlecht2 = $geschlecht2,$AdressenRowguid1 = $rowId1, $AdressenRowguid2 = $rowId2);
                        
                        $anmeldungID = $registration[0];
                    }
                    else{
                   //   First we check if address exists
                       $AddressManager = new beyond_jsonAdressen();
                       $address = $AddressManager->getAdressen(null,null,null,$data['vorname'],$data['name'],null,$data['email']);

                       if (empty($address)){
                        //add address
                        $address = $AddressManager->addAdresse($AdressenRowguid = null,$PostRowguid = null,$VaterRowguid = null,$MutterRowguid = null,$Geschlecht = $geschlecht1,$Titel = null,$AnredeForm = null,$RechnungsArt = null,$Vorname = $data['vorname'],$Nachname = $data['name'],$TelefaxP = null,$TelefonP = $data['telephone'],$TelefonP2 = null,$TelefonG = null,$TelefaxG = null,$TelefonG2 = null,$TelefonN = null,$EMail1 = $data['email'],$EMail1Werbung = null,$EMail2 = null,$EMail2Werbung = null,$EMail3 = null,$EMail3Werbung = null,$OrtP = $data['ort'],$KantonP = null,$LandP = null,$PLZP = $data['plz'],$StrasseP = $data['strasse'],$Grösse = null,$GrösseAnzeigen = null,$Geburtsdatum = $data['birthday'],$GeburtsdatumAnzeigen = null,$AufmerksamDurch = null,$ErstellungVon = null,$ErstellungsDatum = null);
                        $rowId = $address[0];
                       }
                       else{
                        $rowId = $address[0]->rowguid;
                       }
                       //Proceed registration
                       $register = new beyond_jsonAnmeldungen();
                        $registration = $register->addAnmeldungen($AnmeldungsRowguid = null,$KursID = $course->KursID,$Geschlecht1 = $geschlecht1,$Geschlecht2 = null,$AdressenRowguid1 = $rowId);
                        $anmeldungID = $registration[0];
                    
                    }

                    $anmeldungData = '<p><strong>Ihre Anmeldung-Nr.: '.$anmeldungID.'</strong></p>';



                   if ($course->istPaarTanz){
                     $personData .= '<h3>Angaben Partner</h3><table>'.
                   '<tr><td>Name</td><td>'.$data['name2'].'</td></tr>'.
                   '<tr><td>Vorame</td><td>'.$data['vorname2'].'</td></tr>'.
                   '<tr><td>E-Mail-Adresse</td><td>'.$data['email2'].'</td></tr>'.
                   '<tr><td>Geburstdatum</td><td>'.$data['birthday2'].'</td></tr>'.
                   '<tr><td>Strasse</td><td>'.$data['strasse2'].'</td></tr>'.
                   '<tr><td>PLZ / Ort</td><td>'.$data['plz2'].' / '.$data['ort2'].'</td></tr>'.
                   '<tr><td>Telefon</td><td>'.$data['telephone2'].'</td></tr>'.
                   '</table>';
                   }

                   $orderData = $courseData.$personData.$anmeldungData;

                    //Email preparation and sending
                    $AbsoluteThemeDir = Director::AbsoluteBaseURL()."themes/".SSViewer::current_theme();
                    $SubjectNotificationEmail = "Neue Kurs Anmeldung";
                    $LeadNotification =  new DBHTMLText();
                    $LeadNotification->setValue(nl2br("Sie haben eine neue Kurs Anmeldung erhalten."));
                    $HTMLNotification = new DBHTMLText();
                    $HTMLNotification->setValue($orderData);
                    $BodyNotificationEmail = $HTMLNotification;

                    $BodyNotification = $this->renderWith('base_email',array('Subject' => $SubjectNotificationEmail,'Lead' => $LeadNotification, 'Body' => $BodyNotificationEmail, 'Footer' =>'','AbsoluteThemeDir' => $AbsoluteThemeDir ));

                    $SubjectConfirmationEmail = "Ihre Anmeldung ist bestätigt";
                    $LeadConfirmation = new DBHTMLText();
                    $LeadConfirmation->setValue(nl2br("<p>Guten Tag,<br/>Ihre Anmeldung wurde bestätigt. <br/>Vielen Dank, <br/><br/>Tanzschule Art of Dance</p>"));
                    $HTMLConfirmation = new DBHTMLText();
                    $HTMLConfirmation->setValue($orderData);
                    $BodyConfirmationEmail = $HTMLConfirmation;

                    $BodyConfirmation = $this->renderWith('base_email',array('Subject' => $SubjectConfirmationEmail,'Lead' => $LeadConfirmation, 'Body' => $BodyConfirmationEmail, 'Footer' => '','AbsoluteThemeDir' => $AbsoluteThemeDir ));


                    // Send E-Mail
                    $confirmation = new Email( SiteConfig::current_site_config()->AddressEmail , $data['email'] , $SubjectConfirmationEmail, $BodyConfirmation);
                    $email = new Email( SiteConfig::current_site_config()->AddressEmail , SiteConfig::current_site_config()->AddressEmail,$SubjectNotificationEmail , $BodyNotification);
                    $email->addCustomHeader('Reply-To', $data['email']);

                    $email->send();
                    $confirmation->send();

                    return $this->owner->redirect('/kontakt/anmeldung-bestaetigt');
                
            }
        }
        return $this->owner->redirectBack();
    }

}