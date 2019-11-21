<?php
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Email\Email;

class Account_Controller extends PageController {


	private static $allowed_actions = array ('sendcofirmation', 'confirm');

	public function sendcofirmation(  ){
		$member = Member::currentUser();
		$member->EmailConfirmationHash = md5( $member->Email.$member->LastEdited );
		$member->write();


		$config = SiteConfig::current_site_config(); 	

		$body = '<html>
			<body>
				<h2>E-Mail bestätigen</h2>
				<p>Bitte bestätigen Sie Ihre E-Mail Adresse mit einem Klick auf <a href="/account/confirm/'.$member->EmailConfirmationHash.'">diesen Link</p>
			</body>
		</html>';

		$email = new Email( $config->EmailSentFrom , $member->Email, 'E-Mail Bestätigung', $body);

		$email->send();


		$response = array(
			'type' => 'success',
			'msg'  => '<p>Eine Bestätigung wurde an '.$member->Email.' geschickt. Bite klicken Sie in dieser E-Mial auf den Link</p>'
		);

		echo json_encode($response);





	}

	public function confirm( HTTPRequest $request ){
		$member = Member::get()->Filter(array('EmailConfirmationHash' => $request->params()['ID']))->First();
		if( $member ){
			$member->EmailConfirmationHash = null;
			$member->EmailConfirmed = 1;
			$member->write();
		}

		$this->redirect('/mein-koecheportal');
	}





}