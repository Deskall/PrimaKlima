<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;

class UserDefinedFormControllerExtension extends Extension
{
	private static $finished_anchor = '';

	public function updateEmail($email, $recipient, $emailData){
		$email->setHTMLTemplate('email/base_email');
		//to do plain template

                  
		$AbsoluteThemeDir = Director::protocolAndHost()."/".singleton('Page')->ThemeDir();
		$emailData['AbsoluteThemeDir'] = $AbsoluteThemeDir;
		$emailData['AbsoluteBaseUrl'] = Director::AbsoluteBaseUrl();
  			
  			ob_start();
                    print_r($emailData);
                    $result = ob_get_clean();
                    file_put_contents('log.txt',$result);
	}
}