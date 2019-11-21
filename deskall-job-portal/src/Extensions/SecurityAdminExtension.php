<?php

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class SecurityAdminExtension extends Extension {

	public function updateEditForm($form){
		$members = $form->Fields()->FieldByName('Root.Users.Members');
		//exclude other members group
		//Candidat
		$groupCandidat = Group::get()->filter('Code','kandidaten')->first();
		$idsCandidat = ($groupCandidat && $groupCandidat->Members()->exists()) ? $groupCandidat->Members()->column('ID') : [];
		//Employer
		$groupEmployer = Group::get()->filter('Code','arbeitgeber')->first();
		$idsEmployer = ($groupEmployer  && $groupEmployer ->Members()->exists()) ? $groupEmployer->Members()->column('ID') : [];
	
		$ids = array_merge($idsCandidat,$idsEmployer);
		$members->setList(Member::get()->exclude('ID',$ids));
	}
}