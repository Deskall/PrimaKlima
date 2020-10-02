<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class PortfolioCategory extends DataObject {

    private static $singular_name = 'Arbeit';

    private static $plural_name = 'Arbeiten';

    private static $db = [
        'Title' => 'Varchar(255)',
        'URLSegment' => 'Varchar(255)',
        'RefID' => 'Int'
    ];

    private static $belongs_many_many = [
        'Clients' => PortfolioClient::class
    ];

    private static $summary_fields = [
        'Title' => 'Arbeit'
    ];

    private static $extensions = [
        Sortable::class
    ];

    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main',TextField::create('Title','Name'));
        $fields->removeByName('URLSegment');
        $fields->removeByName('Clients');
        return $fields;
    }

    public function onBeforeWrite(){
       parent::onBeforeWrite();
       //to do generate unique
        // $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
        
        
    }
}

