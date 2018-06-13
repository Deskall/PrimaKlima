<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;

class UserDefinedFormControllerExtension extends Extension
{
	private static $finished_anchor = '';

	public function updateEmailData($emailData, $attachments){
		$emailData['AbsoluteThemeDir'] = $this->owner->AbsoluteThemeDir();
		$emailData['AbsoluteBaseUrl'] = Director::AbsoluteBaseUrl();
		$emailData['SiteConfig'] = SiteConfig::current_site_config(); 
	}

	public function AbsoluteThemeDir(){
        return Director::AbsoluteBaseUrl().ThemeResourceLoader::inst()->getThemePaths(SSViewer::get_themes())[0];
    }

	
	public function updateEmail($email, $recipient, $emailData){
		$email->setHTMLTemplate('emails/userform_email');
	}

}