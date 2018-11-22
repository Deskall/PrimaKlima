<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfigLeftAndMain;
use SilverStripe\Assets\Image;
use Bummzack\SortableFile\Forms\SortableUploadField;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class FooterBlock extends LayoutBlock{

	private static $db = [
	];

    private static $has_many = [
        'Links' => LayoutLink::class
    ];

    private static $many_many = ['Partners' => Image::class];

    private static $many_many_extraFields = ['Partners' => ['SortOrder' => 'Int']];

    private static $block_types = [
        'address' => 'Adresse',
        'links' => 'Links',
        'content' => 'Inhalt',
        'logo' => 'Logo',
        'form' => 'Formular',
        'partners' => 'Partners'
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
        $fields->removeByName('Layout');
        $fields->removeByName('Type');
        $fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t('LayoutBlock.Type','BlockTyp'),$this->owner->getTranslatedSourceFor('FooterBlock','block_types'))->setEmptyString(_t('LayoutBlock.TypeLabel','Wählen Sie den Typ aus')),'Title');
        $fields->insertAfter('Title',Wrapper::create(SortableUploadField::create('Partners',_t(__CLASS__.'.Images','Partners'))->setIsMultiUpload(true)->setFolderName(_t(__CLASS__.'.FolderName','Uploads/Einstellungen'))->setAllowedMaxFileNumber(6))->displayIf('Type')->isEqualTo('partners')->end(),'Title');

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