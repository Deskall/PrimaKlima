<?php

use DNADesign\ElementalUserForms\Control\ElementFormController;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\View\Requirements;

class ElementFormControllerExtension extends ElementFormController
{

	 private static $allowed_actions = [
        'finished'
    ];

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