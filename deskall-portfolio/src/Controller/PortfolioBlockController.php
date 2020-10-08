<?php

use DNADesign\Elemental\Controllers\ElementController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\ClassInfo;
use SilverStripe\i18n\i18n;
use SilverStripe\Security\Member;
use SilverStripe\View\Requirements;

class PortfolioBlockController extends ElementController
{

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
        Requirements::javascript('deskall-portfolio/javascript/portfolio.js');
        $template = $this->element->config()->get('controller_template');

        return $this->renderWith([
            'type' => 'Layout',
            $template
        ]);
    }

}