<?php

use SilverStripe\Core\Extension;


class UserDefinedFormControllerExtension extends Extension
{
	
	public function updateEmail($email, $recipient, $emailData){

		$email->setHTMLTemplate('emails/userform_email');
	}

}