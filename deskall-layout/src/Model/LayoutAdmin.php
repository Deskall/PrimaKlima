<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\FieldList;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class LayoutAdmin extends ModelAdmin 
{

    private static $managed_models = [
        SiteConfig::class => 'Layout'
    ];

    private static $url_segment = 'layout';

    private static $menu_title = 'Global Seite Layout';

    private static $menu_icon_class = 'font-icon-block-layout';

    public function getEditForm($id = null,$fields = null){
    	$form = parent::getEditForm($id,$fields);
    	$fields = FieldList::create();
    	$fields->push(new Tabset('Root','Root',
    		new Tab('FooterTab','Footer'),
    		new Tab('MenusTab','Menus'))
    	);

    	$fields->addFieldsToTab('Root.FooterTab',
    		DropdownField::create('FooterBackground',_t(__CLASS__.'.Background','Hintergrundfarbe'),singleton('LayoutBlock')->getTranslatedSourceFor(__CLASS__,'backgrounds'))->setEmptyString(_t(__CLASS__.'.BackgroundHelp','Wählen Sie aus eine Hintergrundfarbe')),
    		$FooterLinksField = new GridField(
		        'FooterBlocks',
		        'FooterBlocks',
		        $this->owner->Blocks(),
		        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
		        ->addComponent(new GridFieldShowHideAction())
    		)
     	);
   
    	$form->setFields($fields);

    	return $form;
    }
}