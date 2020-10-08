<?php

class PortfolioBlock extends TextBlock{

	private static $inline_editable = false;
	
	private static $icon = 'font-icon-p-articles';
	
	private static $controller_template = 'BlockHolder';

	private static $controller_class = PortfolioBlockController::class;

	private static $help_text = "Portfolio Arbeiten";

	public function getType(){
	    return _t(__CLASS__ . '.BlockType', 'Portfolio');
	}


	public function Categories(){
		return PortfolioCategory::get();
	}

	public function activeReferences(){
		return PortfolioClient::get()->filter(['isVisible' => 1, 'ClientActive' => 1]);
	}

	public function inactiveReferences(){
		return PortfolioClient::get()->filter(['isVisible' => 1, 'ClientActive' => 0]);
	}

}

