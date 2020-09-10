<?php

use DNADesign\ElementalUserForms\Control\ElementFormController;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;

class DeskallFormController extends ElementFormController
{

	public function finished()
    {
    	if ($this->element->RedirectPageID > 0){
    		$redirectPage = DataObject::get_by_id(SiteTree::class,$this->element->RedirectPageID);
    		if ($redirectPage){
    			return $this->redirect($redirectPage->Link());
    		}
    	}
    	
    	parent::finished();
        
    }


    /**
     * @param string $action
     *
     * @return string
     */
    public function Link($action = null)
    {  
        $id = $this->element->ID;
        if ($this->element->isChildren()){
            $segment = Controller::join_links('children', $id, $this->element->Parent()->getOwnerPage()->ID, $action);
        }
        else{
            $segment = Controller::join_links('element', $id, $action);
        }
        $page = Director::get_current_page();

        if ($page && !($page instanceof ElementController)) {
            return $page->Link($segment);
        }

        if ($controller = $this->getParentController()) {
            return $controller->Link($segment);
        }

        return $segment;
    }

    /**
     * Renders the managed {@link BaseElement} wrapped with the current
     * {@link ElementController}.
     *
     * @return string HTML
     */
    public function forTemplate()
    {
        $defaultStyles = $this->config()->get('default_styles');
        if ($this->config()->get('include_default_styles') && !empty($defaultStyles)) {
            foreach ($defaultStyles as $stylePath) {
                Requirements::css($stylePath);
            }
        }
        $defaultScripts = $this->config()->get('default_scripts');
         if (!empty($defaultScripts)) {
            foreach ($defaultScripts as $jsPath) {
                Requirements::javascript($jsPath);
            }
        }

        $template = $this->element->config()->get('controller_template');

        return $this->renderWith([
            'type' => 'Layout',
            $template
        ]);
    }

}