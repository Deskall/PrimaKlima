<?php

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;


/**
 * Extension to provide a search interface when applied to ContentController
 *
 * @package cms
 * @subpackage search
 */
class CustomSearchExtension extends Extension
{

    /**
     * generates the fields for the SearchForm
     * @uses updateSearchFields
     * @return FieldList
     */
    public function updateSearchFields($fields)
    {
        foreach ($fields as $field) {
            $field->setAttribute('class','uk-input');
        }
    }

    public function updateSearchActions($actions){
        foreach ($actions as $action){
            $action->addExtraClass('uk-button');
            $action->addExtraClass('dk-button-icon')->setUseButtonTag(true)
            ->setAttribute('data-uk-icon','chevron-right');
        }
    }
}
