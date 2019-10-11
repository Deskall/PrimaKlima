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

class MenuSection extends DataObject{

	private static $db = [
		'Title' => 'Varchar(255)',
		'Text' => 'HTMLText'
	];

	private static $has_one = [
		'Page' => SiteTree::class,
		'Image' => Image::class
	];

	private static $has_many = [
		'Links' => MenuSectionLink::class
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
		$fields->push(UploadField::create('Image',_t(__CLASS__.'.Image','Bild / Icon'))->setFolderName($this->Page()->generateFolderName()));
		$fields->push(HTMLEditorField::create('Text',_t(__CLASS__.'.Text','Einstiegstext'))->setRows(3));
		if ($this->ID > 0){
			$config = GridFieldConfig_RecordEditor::create();
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

	
}