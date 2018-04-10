<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBHTMLText;

use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Permission;

class Color extends DataObject{

	private static $db = [
        'Code' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
        'Color' => 'Varchar(7)',
        'FontColor' => 'Varchar(7)',
        'isReadonly' => 'Boolean(0)',
        'canChangeTitle' => 'Boolean(1)'
	];

    private static $has_one = [
        'Config' => SiteConfig::class
    ];

    public function populateDefaults(){
         
    }

    private static $extensions = [
        'Sortable'
    ];

    private static $summary_fields = [
       
    ];

    public function canCreate($member = null, $context = []){
        if (SiteConfig::current_site_config()->Colors()->count() < 10){
            return true;
        }
        return false;
    }

    public function canDelete($member = null){
        if ($this->isReadonly == 0){
            return true;
        }
        return true;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->Code){
         //   $this->Code = "color-".singleton('Page')->generateURLSegment($this->Title);
        }
    }

	

    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);

	 
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();


		return $fields;
	}





/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}