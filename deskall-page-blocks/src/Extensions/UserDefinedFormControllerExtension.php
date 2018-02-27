<?php
 use SilverStripe\Core\Extension;
 use SilverStripe\Control\Director;
 
class UserDefinedFormControllerExtension extends Extension
{
	private static $finished_anchor = '#anfrage-gesendet';

	public function updateEmail($email, $recipient, $emailData){

		$AbsoluteThemeDir = Director::protocolAndHost().singleton('Page')->ThemeDir();
		$emailData['AbsoluteThemeDir'] = $AbsoluteThemeDir;

	}
}