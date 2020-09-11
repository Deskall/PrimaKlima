<?php

use SilverStripe\Core\Extension;


class UserDefinedFormControllerExtension extends Extension
{
	private static $finished_anchor = '';

	
	public function updateEmail($email, $recipient, $emailData){

		$email->setHTMLTemplate('emails/userform_email');
	}

	public function updateReceivedFormSubmissionData($data) {
		return $this->owner->redirect('/');
	}

}