<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;


class EventCategory extends DataObject{


    private static $db = [
        'Title' => 'Varchar',
        'Subtitle' => 'Text',
        'MenuTitle' => 'Varchar',
        'LeadText' => 'HTMLText',
        'URLSegment' => 'Varchar'
    ];

    private static $has_many = [
        'Events' => Event::class
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Subtitle'] = _t(__CLASS__.'.Subtitle','SubTitel');
        $labels['MenuTitle'] = _t(__CLASS__.'.MenuTitle','Menu');
        $labels['LeadText'] = _t(__CLASS__.'.LeadText','Einstiegtext');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        return $fields;
    }

   

}
