<?php

class FooterBlock extends LayoutBlock{

	private static $db = [
	];

	private static $block_types = [
		'adresse' => 'Adresse',
		'links' => 'Links',
		'content' => 'Inhalt'
	];



	public function NiceTitle(){
		return parent::NiceTitle();
	}


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);

	 
	    return $labels;
	}

	public function getCMSFields(){

		return parent::getCMSFields();
	}

}