<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class MessagePageExtension extends DataExtension {
	public function activeMessages(){
		$activeNews = News::get()->filter('isVisible',1);
		//Postal Code in Session
		$request = Injector::inst()->get(HTTPRequest::class);
		$session = $request->getSession();
		if ($session->get('active_plz')){
			// we take only global and related to code
			print_r($session->get('active_plz'));
			$activeNews = $activeNews->filterByCallback(function($item, $list) use ($session) { return $item->PostalCodes()->count() == 0 || $item->PostalCodes()->filter('Code',$session->get('active_plz'))->count() > 0; });
		}
		return $activeNews;
	}
}
