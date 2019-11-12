<?php


use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Email\Email;


/**
 * Extends text functionnalities in template
 * @author deskall
 */
class MemberConfirmationExtension extends DataExtension
{

	private static $db = array(
		'EmailConfirmed' => 'Boolean',
		'EmailConfirmationHash' => 'Varchar(255)'
	);

	static $defaults = array(
		'EmailConfirmed' => 0
	);


	public function onBeforeWrite(){
		if( $this->owner->isChanged('Email') ){



			$this->owner->EmailConfirmationHash = md5( $this->owner->Email.$this->owner->LastEdited );
			$this->owner->EmailConfirmed = 0;
			$config = SiteConfig::current_site_config(); 	
			$body = '<html>
				<body>
					<h2>E-Mail bestätigen</h2>
					<p>Bitte bestätigen Sie Ihre E-Mail Adresse mit einem Klick auf <a href="/account/confirm/'.$this->owner->EmailConfirmationHash.'">diesen Link</p>
				</body>
			</html>';
			$email = new Email( $config->EmailSentFrom , $this->owner->Email, 'E-Mail Bestätigung', $body);
			$email->send();

		}
		parent::onBeforeWrite();
	}




}