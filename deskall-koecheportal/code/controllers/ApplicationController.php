<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Email\Email;

class Application_Controller extends PageController {

	private static $allowed_actions = array ('ApplicationForm', 'detail');


	public function ApplicationForm( $CookID = 0, $EmployerAdvertisementID = 0 ){
			$fields = new FieldList(
				HeaderField::create('FormTitle', 'Jetzt für Stelle bewerben'),
				LiteralField::create('FormCpation', '<p>Füllen Sie unten stehendes Formular aus, um sich ganz schnell und einfach für ihre Traumstelle zu bewerben.</p>'),

				TextareaField::create('Content', _t('APPLICATION.Content', 'Bewerbungtext')),

				UploadField::create('Attachements', _t('APPLICATION.Attachements', 'Anhänge'))
					->setThumbnailHeight(100)
					->setThumbnailWidth(100)
					->setMultiple(true)
					->setAcceptedFiles(array('.pdf','.doc','.docx'))
					->setPermissions(array(
						'delete' => false,
						'detach' => true)),

					HiddenField::create('CookID' , 'CookID')->SetValue($CookID),
					HiddenField::create('EmployerAdvertisementID' , 'EmployerAdvertisementID')->SetValue($EmployerAdvertisementID)
			);



		$actions = new FieldList(
			FormAction::create('CreateApplication',_t('APPLICATION.Save', 'Bewerbung jetzt senden'))->setUseButtonTag(true)
		);

		$form = new Form($this, __FUNCTION__, $fields, $actions);

//		$required = new RequiredFields([
//			'Email', 'Password', 'MemberGroup'
//		]);
//		$form->setValidator($required);
		return $form;
	}


	public function CreateApplication($data, $form) {
		$Application = CookApplication::create();
		$form->saveInto($Application);
		$Application->write();
		$config = SiteConfig::current_site_config(); 	


		// create E-Mail
		$Subject = 'Neue Bewerbung auf Inserat «'.$Application->EmployerAdvertisement()->Title.'»';

		$body = '<html>
			<body>
				<h2>Neue Bewerbung erhalten für Inserat  «'.$Application->EmployerAdvertisement()->Title.'»:</h2>
				<p>'.$Application->Content.'

				<h3>Angaben zum Bewerber:</h3>
				<p>
					Vorname: '.$Application->Cook()->FirstName.'<br/>
					Nachname: '.$Application->Cook()->Surname.'<br/>

					Adresse: '.$Application->Cook()->Address.'<br/>
					'.$Application->Cook()->PostalCode.' '.$Application->Cook()->Place.', '.$Application->Cook()->Country.' <br/>

					E-Mail: '.$Application->Cook()->Email.' <br/><br/>

					<a href="/cook/detail/candidate/'.$Application->Cook()->ID.'" target="_blank">Bewerber-Profil</a>

			</body>
		</html>';
		$ApplicationEmail = new Email( $config->EmailSentFrom , $Application->EmployerAdvertisement()->Employer()->Email, $Subject, $body);
		foreach ($Application->Attachements() as $Attachment) {
			$ApplicationEmail->attachFile( $Attachment->Filename );
		}
		$ApplicationEmail->send();
		$this->redirect('/mein-koecheportal/#applications');
	}


	public function detail( HTTPRequest $request ){
		
		$Application = DataObject::get_by_id("CookApplication", $request->params()['ID'] );
		$Employer = Member::currentUser();




		if( $Application->ID > 0 && ( $Application->EmployerAdvertisement()->EmployerID == $Employer->ID || $Application->CookID == $Employer->ID ) ){

			if( $Application->EmployerAdvertisement()->EmployerID == $Employer->ID ){
				$Application->isRead = 1;
				$Application->write();
			}



			return json_encode(array(
				'Content' => $Application->renderWith('Application_details')->RAW(),
				'Title'   => 'Bewerbungsdetails'
			));
		}else{
			$this->httpError(404);
		}




	}



}