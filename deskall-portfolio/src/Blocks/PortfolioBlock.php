<?php

class PortfolioBlock extends TextBlock{

	private static $inline_editable = false;
	
	private static $icon = 'font-icon-p-articles';
	
	private static $controller_template = 'BlockHolder';

	private static $controller_class = BlockController::class;

	private static $help_text = "Portfolio Arbeiten";

	public function Clients( $state ) {
		if( $state == 'active' ){
			return PortfolioClient::get()->filter(array('isVisible' => true))->filter(array('ClientActive' => true));
		}elseif( $state == 'notactive' ){	
			return PortfolioClient::get()->filter(array('isVisible' => true))->filter(array('ClientActive' => 0));
		}else{
			return PortfolioClient::get()->filter(array('isVisible' => true));
		}
	}

	public function Categories(){
		return PortfolioCategory::get();
	}

	public function activeReferences(){
		return PortfolioClient::get();
	}

	public function ClientDetail(){

		$pathsegs = explode("/",  $_SERVER['REQUEST_URI'] );

		$Client = PortfolioClient::get()->filter(array('URLSegment' => $pathsegs))->First();

		if( $Client ){
			return $Client->renderWith("PortolioClientDetail");	
		}else{
			return false;
		}
	}

}

