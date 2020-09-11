<?php

use SilverStripe\Core\Extension;


class UserDefinedFormControllerExtension extends Extension
{
	
	public function updateEmail($email, $recipient, $emailData){

		$email->setHTMLTemplate('emails/userform_email');
	}

	public function updateReceivedFormSubmissionData($data) {
		ob_start();
			print_r('la');
			$result = ob_get_clean();
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
		return $this->owner->redirect('/');
	}

}