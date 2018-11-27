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

    private static $many_many = ['Items' => ListItem::class];

    private static $many_many_extraFields = ['Items' => ['SortOrder' => 'Int']];

    private static $block_types = [
        'address' => 'Adresse',
        'links' => 'Links',
        'content' => 'Inhalt',
        'logo' => 'Logo',
        'form' => 'Formular',
        'items' => 'List mit Items'
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
        $fields->removeByName('Items');
        $fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t('LayoutBlock.Type','BlockTyp'),$this->owner->getTranslatedSourceFor('FooterBlock','block_types'))->setEmptyString(_t('LayoutBlock.TypeLabel','Wählen Sie den Typ aus')),'Title');
        $fields->insertAfter('Title',Wrapper::create(GridField::create('Items',_t(__CLASS__.".Items",'Items'),$this->Items()))->displayIf('Type')->isEqualTo('items')->end());

		return $fields;
	}



	/**
     * @return null|string
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function CMSEditLink()
    {
        $editLinkPrefix = Controller::join_links(ThemeLeftAndMain::singleton()->Link('EditForm'));
        
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