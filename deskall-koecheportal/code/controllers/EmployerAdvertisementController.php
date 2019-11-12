<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\MemberAuthenticator\MemberLoginForm;
use SilverStripe\Security\Security;
use SilverStripe\Security\Permission;

class EmployerAdvertisement_Controller extends PageController {

	/* 
		URLs
		cook/detail/rental/$ID 		> Mietkoch-Profil von KOch mit $ID 
		cook/detail/candidate/$ID 	> Bewerber-Profil von KOch mit $ID 

		cook/listing/rental/  		> Alle Mietköche
		cook/listing/candidate  	> Alle Bewerber

	*/

	private static $allowed_actions = array ('detail', 'listing','login');

    private static $url_handlers = array(
        'detail/$ID!' => 'detail',

        'listing/postal/$Postal!/position/$Position!' => 'listing',
        'listing/position/$Position!/postal/$Postal!' => 'listing',
        'listing/postal/$Postal!' => 'listing',
        'listing/position/$Position!' => 'listing',

        'listing' => 'listing',
    );



	function login(HTTPRequest $request) {
		$loginForm = new MemberLoginForm( $this , 'CookLogIn' );
		$data = $request->postVars();

		$LoggedInMember = $loginForm->performLogin( $data );

		if( $LoggedInMember->ID && $LoggedInMember->ClassName != 'Cook' ){
			$this->redirect('/mein-koecheportal');
		}else{
			if( $data['redirect'] ){
				$this->redirect('ad/detail/'.$data['redirect']);
			}
			$this->redirectBack();
		}
	}

	public function updateAdvertisements(){
		// find and deactivate expired ads

		$AllAdvertisements = EmployerAdvertisement::get()->filter(array(
			'isPaid' => true, 
			'State'  => 'live'
		));

		$NonFlatRateAds = $AllAdvertisements->filter(array(
			'PackageID:LessThan' => 3,
			'EndDate:LessThanOrEqual' => date("Y-m-d"),
		));
	
		foreach ($NonFlatRateAds as $ad ) {
			$ad->State = 'draft';
			$ad->isPaid = false;
			$ad->startDate = null;
			$ad->EndDateDate = null;
			$ad->PackageID = null;
			$ad->write();
		}

		$FlatRateAds = $AllAdvertisements->filter(array(
			'PackageID' => 3,
			'Employer.FlatrateEndDate:LessThanOrEqual' => date("Y-m-d"),
		));

		foreach ($FlatRateAds as $ad ) {
			$ad->State = 'draft';
			$ad->isPaid = false;
			$ad->startDate = null;
			$ad->EndDateDate = null;
			$ad->PackageID = null;
			$ad->write();
		}

	}



	function detail(HTTPRequest $request) {

		$Advertisement = DataObject::get_by_id("EmployerAdvertisement", $request->params()['ID'] );

		if( $Advertisement && ( strtotime($Advertisement->Employer()->FlatrateEndDate) >= time() || (  strtotime($Advertisement->StartDate) <= time() && strtotime($Advertisement->EndDate) >= time() )  ) ){

			if( Security::getCurrentUser() && ( Security::getCurrentUser()->ClassName == "Cook" || $Advertisement->EmployerID == Security::getCurrentUser()->ID ) ){
				return array('Advertisement' => $Advertisement, 'CookLoggedIn' => true, 'Title' => 'Stelleninserat '.$Advertisement->ContentTitle );
			}else{
				if( $request->isAjax() ){
					return $this->renderWith('CookLoginForm_Ajax');
				}else{
					return array('Advertisement' => $Advertisement, 'Title' => 'Stelleninserat '.$Advertisement->ContentTitle );
				}
			}
		}else{
			$this->httpError(404);
		}
	}

	function listing(HTTPRequest $request) {
		



		$Advertisements = EmployerAdvertisement::get()->filter(array(
			'isPaid' => true, 
			'State'  => 'live'
		));

//		$NonFlatRateAds = $AllAdvertisements->filter(array(
//			'PackageID:LessThan' => 3,
//			'StartDate:LessThanOrEqual' => date("Y-m-d"),
//			'EndDate:GreaterThanOrEqual' => date("Y-m-d"),
//		));
//
//		$FlatRateAds = $AllAdvertisements->filter(array(
//			'PackageID' => 3,
//			'StartDate:LessThanOrEqual' => date("Y-m-d"),
//			'Employer.FlatrateEndDate:GreaterThanOrEqual' => date("Y-m-d"),
//		));
//
//		$Advertisements = new ArrayList;
//
//		foreach( $NonFlatRateAds as $ad){$Advertisements->push($ad);}
//		foreach( $FlatRateAds as $ad){$Advertisements->push($ad);};

		$returnValue  = array();


		if( array_key_exists( 'Postal', $request->params() ) ){
			$params = explode( '-', $request->params()['Postal'] );

			$Advertisements = $Advertisements->filter( array('Employer.AddressCountry' => $params[0] ) );
			$Advertisements = $Advertisements->filter( array('Employer.AddressPostalCode' => $params[1] ) );

			$returnValue['FilterPostal'] = $request->params()['Postal'];
		}

		if( array_key_exists( 'Position', $request->params() ) ){
			$Advertisements = $Advertisements->filterAny(array(
				'ContentTitle:PartialMatch:nocase' => base64_decode($request->params()['Position']),
			));

			$returnValue['FilterPosition'] = $request->params()['Position'];
		}

		$returnValue['Advertisements'] = $Advertisements;
		$returnValue['Title'] = 'Offene Stellen';

		if( Security::getCurrentUser() && Security::getCurrentUser()->ClassName == "Cook" ){
			$returnValue['CookLoggedIn'] = true;
		}

		return $returnValue;
	}

}