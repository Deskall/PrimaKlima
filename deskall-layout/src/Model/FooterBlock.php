<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfigLeftAndMain;

class FooterBlock extends LayoutBlock{

	private static $db = [
	];

    private static $has_many = [
        'Links' => LayoutLink::class
    ];

    private static $block_types = [
        'adresse' => 'Adresse',
        'links' => 'Links',
        'content' => 'Inhalt',
        'logo' => 'Logo',
        'form' => 'Formular'
    ];

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
}