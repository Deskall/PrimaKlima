<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Tab;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\SiteConfig\SiteConfig;

class Header extends DataObject
{

    private static $db = [
        'Title' => 'Text',
        'Format' => 'Varchar',
        'TextAlign' => 'Varchar(255)'
    ];

    private static $has_one = [
        'Parent' => TableBlock::class
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    private static $defaults = [
       'Format' => '',
       'TextAlign' => 'uk-text-left'
    ];


    private static $formats = [
        '' => 'standard',
        'uk-table-expand'  => 'erweitern',
        'uk-table-shrink'   => 'schrumpfen'
    ];


   
    private static $text_alignments = [
        'uk-text-left' =>  [
            'value' => 'uk-text-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'uk-text-right' => [
            'value' => 'uk-text-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-right-align.svg'
        ],
        'uk-text-center' =>  [
            'value' => 'uk-text-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-center-align.svg'
        ],
        'uk-text-justify' =>  [
            'value' => 'uk-text-justify',
            'title' => 'Justify Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-justify-align.svg'
        ]
    ];


    private static $summary_fields = [
        'Title' ,
        'Format' ,
        'TextAlign'
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['Format'] = _t(__CLASS__.'.Format', 'Breite');
        $labels['TextAlign'] = _t(__CLASS__.'.TextAlign',  'Textausrichtung');
      

        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->removeByName('TextAlign');
        $fields->removeByName('Format');
      
        $fields->addFieldsToTab('Root.Main',[
            HTMLOptionsetField::create('TextAlign',$this->fieldLabels()['TextAlign'],$this->stat('text_alignments')),
           DropdownField::create('Format',$this->fieldLabels()['Format'],$this->stat('formats'))
        ]);
           

        return $fields;
    }


/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        return $entities;
    }

/************* END TRANLSATIONS *******************/

}
