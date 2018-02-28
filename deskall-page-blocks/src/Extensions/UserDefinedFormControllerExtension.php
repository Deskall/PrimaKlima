<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;

class UserDefinedFormControllerExtension extends Extension
{
	private static $finished_anchor = '';

	public function updateEmail($email, $recipient, $emailData){
		$email->setHTMLTemplate('email/base_email')
                    ->setPlainTemplate('email/SubmittedFormEmail');
                    ob_start();
                    print_r($email);
                    $result = ob_get_clean();
                    file_put_contents('log.txt',$result);
		$AbsoluteThemeDir = Director::protocolAndHost().singleton('Page')->ThemeDir();
		$emailData['AbsoluteThemeDir'] = $AbsoluteThemeDir;

	}
}