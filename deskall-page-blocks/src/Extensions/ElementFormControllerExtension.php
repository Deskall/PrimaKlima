<?php

use DNADesign\ElementalUserForms\Control\ElementFormController;
use SilverStripe\Control\Director;

class ElementFormControllerExtension extends ElementFormController
{

	 private static $allowed_actions = [
        'finished'
    ];

	public function finished()
    {
        return $this->redirect('/');
    }

}