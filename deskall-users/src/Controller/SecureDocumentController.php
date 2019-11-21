<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Security\Security;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Assets\File;

class SecureDocumentController extends PageController{

	private static $allowed_actions = ['download'];

	public function init(){
		parent::init();
		if (!Security::getCurrentUser()){
			return Security::permissionFailure($this, _t(
				'MemberProfiles.NeedToLogin',
				'You must log in to access this page'
			));
		}
	}

	public function download(HTTPRequest $request){
		$id = $request->param('ID');
		if ($id){
			$file = File::get()->filter('ID',$id)->first();
			if ($file && $file->canView()){
				return $this->redirect($file->getURL());
			}
			else{
				$this->setResponse(new HTTPResponse());
    			$this->getResponse()->setStatusCode(503);
			}
		}
		else{
			$this->setResponse(new HTTPResponse());
    		$this->getResponse()->setStatusCode(404);
		}


    	return $this->getResponse();
	}


}