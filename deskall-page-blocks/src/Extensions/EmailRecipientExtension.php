<?php

use SilverStripe\ORM\DataExtension;



class EmailRecipientExtension extends DataExtension
{

     /**
     * overrided to select ElementForm CLass instead of Userdefined
     *
     * @return ElementFrom
     */
    protected function getFormParent()
    {
        // LeftAndMain::sessionNamespace is protected. @todo replace this with a non-deprecated equivalent.
        $sessionNamespace = $this->config()->get('session_namespace') ?: LeftAndMain::class;

        $formID = $this->FormID
            ? $this->FormID
            : Controller::curr()->getRequest()->getSession()->get($sessionNamespace . '.currentPage');
        return ElementForm::get()->byID($formID);
    }


}