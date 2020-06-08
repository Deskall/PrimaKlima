<?php

class MatchingToolPage extends Page {
	
	public function canCreate( $member = null, $context = []){
	    if (MatchingToolPage::get()->count() == 0){
	    	return true;
	    }
	    return false;
	}
}