<?php

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\SiteConfig\SiteConfig;

class CoursePageControllerExtension extends Extension
{
   private static $allowed_actions = ['kursDetails','SendKurseForm'];

	private static $url_handlers = [
	    'kurs-details/$ID' => 'kursDetails'
	];

	public function kursDetails(SS_HTTPRequest $request){
		$KursID = $request->param('ID');
		if ($KursID){
      		$Api = new beyond_jsonKurse();
     		$data = $Api->getKurse(null,$KursID);
     		if (is_array($data) and isset($data[0])){
     			return array(
     				'kursData' => new ArrayData($data[0]),
     				'Title' => $data[0]->Titel
     			);
     		}
      	}
        return $this->httpError(404);
	}

}