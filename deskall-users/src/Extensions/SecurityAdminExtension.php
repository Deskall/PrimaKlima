<?php

use SilverStripe\Core\Extension;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

class SecurityAdminExtension extends Extension {

	public function updateEditForm($form){
		$members = $form->Fields()->FieldByName('Root.Users.Members');
		//exclude other members group
		$idsCook = Group::get()->filter('Code','mietkoeche')->first()->Members()->column('ID');
		$idsCustomer = Group::get()->filter('Code','kunden')->first()->Members()->column('ID');
		$idShopCustomer = Group::get()->filter('Code','shop-kunden')->first()->Members()->column('ID');
		$ids = array_merge($idsCook,$idsCustomer,$idShopCustomer);
		$members->setList(Member::get()->exclude('ID',$ids));
	}
}