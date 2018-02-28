<?php

use DNADesign\ElementalUserForms\Control\ElementFormController;
use SilverStripe\Control\Director;

class ElementFormControllerExtension extends ElementFormController
{

	public function finished()
    {
        return $this->redirect('/');
    }

}