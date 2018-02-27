<?php
 use SilverStripe\Core\Extension;

class UserDefinedFormControllerExtension extends Extension
{

	public function updateEmail($email, $recipient, $emailData){

		$AbsoluteThemeDir = Director::protocolAndHost().singleton('Page')->ThemeDir();
		$emailData['AbsoluteThemeDir'] = $AbsoluteThemeDir;

	}
}