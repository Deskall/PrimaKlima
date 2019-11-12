<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\MemberAuthenticator\MemberLoginForm;
use SilverStripe\Security\Security;
use SilverStripe\Security\Permission;

class Cook_Controller extends PageController {

	/* 
		URLs
		cook/detail/rental/$ID 		> Mietkoch-Profil von KOch mit $ID 
		cook/detail/candidate/$ID 	> Bewerber-Profil von KOch mit $ID 

		cook/listing/rental/  		> Alle Mietköche
		cook/listing/candidate  	> Alle Bewerber

	*/

	private static $allowed_actions = array ('detail', 'listing','login');

    private static $url_handlers = array(
        'detail/$Type!/$ID!' => 'detail',
        'listing/$Type!' => 'listing',
    );


	public function GetUserData( $fieldname ){
		$member = Security::getCurrentUser();
		return $member->{$fieldname};
	}


	function login(HTTPRequest $request) {


		$loginForm = new MemberLoginForm( $this , 'EmployerLogIn' );
		$data = $request->postVars();

		$LoggedInMember = $loginForm->performLogin( $data );

		if( $LoggedInMember->ID && $LoggedInMember->ClassName != 'Employer' ){
			$this->redirect('/mein-koecheportal');
		}else{
			$this->redirectBack();
		}

	}




	function detail(HTTPRequest $request) {

		$Cook = DataObject::get_by_id("Cook", $request->params()['ID'] );

		if( $Cook ){



			if(  Permission::check('ADMIN') || ( Security::getCurrentUser() && ( ( Security::getCurrentUser()->ClassName == "Employer" && $Cook->hasAppliedFor(Security::getCurrentUser()->ID) ) || $Cook->ID == Security::getCurrentUser()->ID ) ) ){
				if( $request->params()['Type'] == 'rental' ){		
					if( $Cook->isRental ){
						// render cook as rental
						return array('Cook' => $Cook, 'template' => 'rental');
					}else{
						$this->httpError(404);
					}
				}elseif( $request->params()['Type'] == 'candidate'){
					if( $Cook->isCandidate ){
						// render cook as candidate
						return array('Cook' => $Cook, 'template' => 'candidate', 'Title' => 'Bewerber-Profil '.$Cook->FirstName.' '.$Cook->Surname);

					}else{
						$this->httpError(404);
					}
				}else{
					$this->httpError(404);
				}
			}else{

				return array('Cook' => $Cook, 'template' => 'login', 'Title' => 'Kochprofil', 'LoginForm' =>  MemberLoginForm::create( $this , 'EmployerLogIn' )->setFormAction('/cook/login/') );


			}


		}else{
			$this->httpError(404);
		}
	}

	function listing(HTTPRequest $request) {
		if( $request->params()['Type'] == 'rental' ){	
			print_r($request);
		}elseif( $request->params()['Type'] == 'candidate'){
			print_r($request);
		}else{
			$this->httpError(404);
		}
	}
}


