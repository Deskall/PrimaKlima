<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;

class Testimonial extends DataObject {

    private static $singular_name = 'Kundenstimme';
    private static $plural_name = 'Kundenstimmen';

    private static $db = [
        'Content'   => 'HTMLText',
        'Author' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Client' => PortfolioClient::class
    ];

	private static $summary_fields = [
    	'Content.BigSummary' => 'Aussage',
		'Author' => 'Autor Name'
	];


	public function getTitleForMap() {
	    return ($this->Client()->exists() ) ? $this->Client()->Title : '(Keine)';
	}

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName("ClientID");
        
        $fields->addFieldToTab('Root.Main',TextareaField::create('Content','Aussage'));    
        $fields->addFieldToTab('Root.Main',TextField::create('Author','Autor'));   
        return $fields;  
	}
}