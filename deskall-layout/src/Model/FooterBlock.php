<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfigLeftAndMain;

class FooterBlock extends LayoutBlock{

	private static $db = [
	];

	private static $block_types = [
		'adresse' => 'Adresse',
		'links' => 'Links',
		'content' => 'Inhalt'
	];

    private static $has_many = [
        'Links' => LayoutLink::class
    ];



	public function NiceTitle(){
		return parent::NiceTitle();
	}

	public function Preview(){
     $Preview = new DBHTMLText();
     $Preview->setValue($this->renderWith(__CLASS__.'_preview'));
     return $Preview;
    }


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);

	 
	    return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t(__CLASS__.'.Type','BlockTyp'),$this->getTranslatedSourceFor(__CLASS__,'block_types'))->setEmptyString(_t(__CLASS__.'.TypeLabel','Wählen Sie den Typ aus')),'Title');

		return $fields;
	}



	/**
     * @return null|string
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function CMSEditLink()
    {
        $editLinkPrefix = Controller::join_links(SiteConfigLeftAndMain::singleton()->Link('EditForm'));
        
        $link = Controller::join_links(
            $editLinkPrefix,
            'field/FooterBlocks/item/',
            $this->ID
        );

        $link = Controller::join_links(
            $link,
            'edit'
        );
       
        return $link;
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        foreach($this->stat('block_types') as $key => $value) {
          $entities[__CLASS__.".block_types_{$key}"] = $value;
        }
         
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}