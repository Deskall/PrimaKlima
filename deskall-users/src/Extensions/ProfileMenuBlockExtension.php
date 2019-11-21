<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Group;
use SilverStripe\Security\Security;
class ProfileMenuBlockExtension extends DataExtension{
	private static $block_types = [
		'Profile' => 'Menu de profile'
	];


	public function ProfilPages(){
	    return Page::get()->filter('ClassName',['MemberProfilePage','RegisterPage'])->sort('Sort');
	}

}