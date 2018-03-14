<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LabelField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\Tab;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Control\PjaxResponseNegotiator;

class ThemeAdmin extends ModelAdmin 
{

    private static $managed_models = [
    	SiteConfig::class => ['title' => 'Layout Konfiguration']
    ];

    private static $url_segment = 'Theme';

    private static $allowed_actions = ['saveLayout'];

    private static $menu_title = 'Theme';

    private static $menu_icon_class = "font-icon-block-layout";

    public function getEditForm($id = null, $fields = null) {
    	$config = SiteConfig::current_site_config();
    	$fields = FieldList::create(
    		HeaderField::create('LayoutTitle',_t(__CLASS__.'LayoutTitle','Layout Konfiguration'),3),
    		LabelField::create('LabelField',_t(__CLASS__.'LayoutHelp','Einfach erklären'))
    	);
    	//Tabs
    	$fields->push(new Tabset('Root',
    		new Tab('General',_t(__CLASS__.'General','Allgemein')),
    		new Tab('Footer',_t(__CLASS__.'Footer','Footer')),
    		new Tab('Menus',_t(__CLASS__.'Menus','Menus'))
    		)
    	);

    	//General
		$fields->addFieldsToTab('Root.General',[
				TextField::create('GlobalBackground','Body Hintergrundfarbe')
			]
		);

		//Footer
		$fields->addFieldsToTab('Root.Footer',[
			DropdownField::create('FooterBackground',_t(__CLASS__.'.Background','Hintergrundfarbe'),Config::inst()->get('FooterExtension','backgrounds'))->setEmptyString(_t(__CLASS__.'.BackgroundHelp','Wählen Sie aus eine Hintergrundfarbe')),
			new GridField(
		        'Blocks',
		        'Blocks',
		        $config->Blocks(),
		        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('Sort'))
		        ->addComponent(new GridFieldShowHideAction())
		    )]
		);
   

		//Menus
		$actions = FieldList::create(
			FormAction::create('saveLayout')->setTitle('Theme speichern')->addExtraClass('btn action btn-primary font-icon-save')->setUseButtonTag(true)
		);
		
		$form = Form::create(
	            $this,
	            'EditForm',
	            $fields,
				$actions	            
	        )->setHTMLID('Form_EditForm');
	        $form->addExtraClass('cms-edit-form cms-panel-padded fill-height SiteConfigLayout center flexbox-area-grow');
	        $form->setTemplate('SiteConfig_LayoutEditForm');
	        $editFormAction = Controller::join_links($this->Link($this->sanitiseClassName($this->modelClass)), 'EditForm');
	        $form->setFormAction($editFormAction);
	        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

	        $form->loadDataFrom($config);

	        return $form;
		
	}

	public function saveLayout($data, $form) {

		$config = SiteConfig::current_site_config();
		$form->saveInto($config);
		$config->write();
		$form->sessionMessage(_t(__CLASS__.'.LAYOUT_SETTINGS_SAVED_MESSAGE','Layout Einstellungen gespeichert'), 'good');

		$controller = $this;
		
		$responseNegotiator = new PjaxResponseNegotiator(
			array(
				'CurrentForm' => function() use(&$controller) {
					//return $controller->renderWith('ShopAdminSettings_Content');
					return $controller->getEditForm()->forTemplate();
				},
				'Content' => function() use(&$controller) {
					//return $controller->renderWith($controller->getTemplatesWithSuffix('_Content'));
				},
				'Breadcrumbs' => function() use (&$controller) {
					return $controller->renderWith('Silverstripe\Admin\Includes\CMSBreadcrumbs');
				},
				'default' => function() use(&$controller) {
					return $controller->renderWith($controller->getViewer('show'));
				}
			),
			$this->response
		); 
		return $responseNegotiator->respond($this->getRequest());
	

	}

		
}