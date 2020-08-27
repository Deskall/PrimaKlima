<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class MenuSection extends DataObject{

	private static $db = [
		'Title' => 'Varchar(255)',
		'Text' => 'HTMLText'
	];

	private static $has_one = [
		'Page' => Page::class,
		'Image' => Image::class
	];

	private static $has_many = [
		'Links' => MenuSectionLink::class
	];

	private static $extensions = [
		'Activable',
		'Sortable'
	];

	private static $owns = ['Links'];


    function fieldLabels($includerelations = true) {
	    $labels = parent::fieldLabels($includerelations);
	    $labels['Title'] = 'Titel';
	    $labels['Links'] = 'Links';
	    $labels['Image'] = 'Bild / Icon';

	 
	    return $labels;
	}

	

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Links');
		$fields->removeByName('PageID');
		$fields->removeByName('Image');
		$fields->insertAfter('Title',HTMLEditorField::create('Text',_t(__CLASS__.'.Text','Einstiegstext'))->setRows(3));
		
		
		if ($this->ID > 0){
			$fields->insertAfter('Text',UploadField::create('Image',_t(__CLASS__.'.Image','Bild / Icon'))->setFolderName($this->Page()->generateFolderName()));
			$config = GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction());
			// $config->removeComponentsByType(GridFieldAddNewButton::class);
			// $config->addComponent(new GridFieldEditableColumns())->addComponent(new GridFieldAddNewInlineButton());
			// $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
			// 	'SecondField' => array(
			// 		'title' => 'Link',
			// 		'field' => LinkField::class
			// 	)
			// ));
			$fields->addFieldToTab('Root.Main',
				GridField::create('Links','Links',$this->Links(),$config)
			);
		}
		

		
		

		return $fields;
	}

	public function activeLinks(){
		return $this->Links()->filter('isVisible',1)->sort('Sort');
	}


	
}