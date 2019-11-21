<?php

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class SecurityAdminExtension extends Extension {

	public function updateEditForm($form){
		$members = $form->Fields()->FieldByName('Root.Users.Members');
		//exclude other members group
		$idsCandidat = Group::get()->filter('Code','kandidaten')->first()->Members()->column('ID');
		$idsCustomer = Group::get()->filter('Code','arbeitgeber')->first()->Members()->column('ID');
		$ids = array_merge($idsCandidat,$idsCustomer);
		$members->setList(Member::get()->exclude('ID',$ids));
	}
}