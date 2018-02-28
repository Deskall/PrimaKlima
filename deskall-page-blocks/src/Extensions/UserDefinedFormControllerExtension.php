<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;

class UserDefinedFormControllerExtension extends Extension
{
	private static $finished_anchor = '';


	public function updateEmailData($emailData, $attachments){
		$emailData['AbsoluteThemeDir'] = Director::protocolAndHost()."/".singleton('Page')->ThemeDir();
		$emailData['AbsoluteBaseUrl'] = Director::AbsoluteBaseUrl();
	}

	public function updateEmail($email, $recipient, $emailData){
		ob_start();
                    print_r($emailData);
                    $result = ob_get_clean();
                    file_put_contents('log.txt',$result);
		$email->setHTMLTemplate('email/base_email');
	}
}