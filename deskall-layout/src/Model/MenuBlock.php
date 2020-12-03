<?php

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\TextField;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfigLeftAndMain;
use SilverStripe\CMS\Model\SiteTree;

use SilverStripe\CMS\Controllers\ContentController;

class MenuBlock extends LayoutBlock{

	private static $db = [
		'UseMenu' => 'Boolean(0)',
		'UseMenuOption' => 'Varchar(255)',
		'ShowSubLevels' => 'Boolean(0)',
		'SubLevelLayout' => 'Varchar(255)',
		'isMobile' => 'Boolean(0)'
	];

	private static $has_many = [
		'Links' => MenuLink::class
	];

	private static $block_types = [
		'links' => 'Links',
		'logo' => 'Logo'/*,
		'form' => 'Formular'*/
	];

	private static $menu_options = [
		'main' => 'Hauptmenu',
		'sub' => 'Untenmenu'
	];

	private static $defaults = ['isMobile' => 0];



	public function NiceTitle(){
		return parent::NiceTitle();
	}

	public function onAfterWrite(){
		if ($this->Logo()->ID > 0){
			$this->Logo()->publishSingle();
		}
		
		parent::onAfterWrite();
	}


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);

	 
	    return $labels;
	}

	public function Preview(){
     $Preview = new DBHTMLText();
     $Preview->setValue($this->renderWith(__CLASS__.'_preview'));
     return $Preview;
    }

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Title');
		$fields->removeByName('UseMenu');
		$fields->removeByName('UseMenuOption');
		$fields->removeByName('isMobile');
		$fields->removeByName('ShowSubLevels');
		$fields->removeByName('Width');

	//	$fields->addFieldToTab('Root.Main', DropdownField::create('Type',_t(__CLASS__.'.Type','BlockTyp'),$this->getTranslatedSourceFor(__CLASS__,'block_types'))->setEmptyString(_t(__CLASS__.'.TypeLabel','Wählen Sie den Typ aus')));
		

		$fields->addFieldToTab('Root.Main',Wrapper::create(CompositeField::create(
			CheckboxField::create('UseMenu',_t(__CLASS__.'.UseMenu','Site Struktur benutzen'))->displayIf('Type')->isEqualTo('links')->end(),
			DropdownField::create('UseMenuOption',_t(__CLASS__.'.UseWhichMenu','Welche Menu benutzen?'),$this->getTranslatedSourceFor(__CLASS__,'menu_options'))->displayIf('UseMenu')->isChecked()->end(),
			CheckboxField::create('ShowSubLevels',_t(__CLASS__.'.ShowSubLevels','Navigation anzeigen'))->displayIf('UseMenu')->isChecked()->andIf('UseMenuOption')->isEqualTo('main')->end()
		))->setTitle(_t(__CLASS__.'.MenuSettings','Menu Einstellungen'))->setName('MenuSettings'));

		$fields->insertAfter(TextField::create('SubLevelLayout',_t(__CLASS__.'.SubLevelLayout','Unten Navigation Layout'))->displayIf('ShowSubLevels')->isChecked()->end(),'Width');


		if ($linksfield = $fields->fieldByName('Root.Main.LinksField')){
			$linksfield->displayIf('Type')->isEqualTo('links')->andIf('UseMenu')->isNotChecked();
		}

		$fields->fieldByName('Root.Main.MenuSettings')->displayIf('Type')->isEqualTo('links');

		
		

		return $fields;
	}

	public function getMenu(){
		$menu = ContentController::create()->getMenu(1);
		if ($this->UseMenu){
			if ($this->UseMenuOption == "main"){
				$menu = $menu->filter('ShowInMainMenu',[1,3]);
			}
			else{
				$menu = $menu->filter(['ShowInMainMenu' => [2,3],'ShowInMenus' => 1]);
			}
		}
		return $menu;
	}

	public function forTemplate(){
		return $this->renderWith('Includes/MenuBlock_'.$this->Type);
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
            'field/MenuBlocks/item/',
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
        foreach($this->stat('menu_options') as $key => $value) {
          $entities[__CLASS__.".menu_options_{$key}"] = $value;
        }
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}