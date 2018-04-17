<?php

use DNADesign\ElementalVirtual\Forms\ElementalGridFieldAddExistingAutocompleter;

use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\SS_List;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\GridField\GridField_FormAction;



class DeskallGridFieldAddExistingBlockAutocompleter extends ElementalGridFieldAddExistingAutocompleter
{

      /**
     *
     * @param GridField $gridField
     * @return string[] - HTML
     */
    public function getHTMLFragments($gridField)
    {
        $dataClass = $gridField->getModelClass();

        $forTemplate = new ArrayData(array());
        $forTemplate->Fields = new FieldList();

        $searchField = new TextField('gridfield_relationsearch', _t('SilverStripe\\Forms\\GridField\\GridField.RelationSearch', "Relation search"));

        $searchField->setAttribute('data-search-url', Controller::join_links($gridField->Link('search')));
        $searchField->setAttribute('placeholder', $this->getPlaceholderText($dataClass));
        $searchField->addExtraClass('relation-search no-change-track action_gridfield_relationsearch');

        $findAction = new GridField_FormAction(
            $gridField,
            'gridfield_relationfind',
            _t('SilverStripe\\Forms\\GridField\\GridField.Find', "Find"),
            'find',
            'find'
        );
        $findAction->setAttribute('data-icon', 'relationfind');
        $findAction->addExtraClass('action_gridfield_relationfind');

        $addAction = new GridField_FormAction(
            $gridField,
            'gridfield_relationadd',
            _t('SilverStripe\\Forms\\GridField\\GridField.LinkExisting', "Link Existing"),
            'addto',
            'addto'
        );
        $addAction->setAttribute('data-icon', 'chain--plus');
        $addAction->addExtraClass('btn btn-outline-secondary font-icon-link action_gridfield_relationadd');

        // If an object is not found, disable the action
        if (!is_int($gridField->State->GridFieldAddRelation(null))) {
            $addAction->setReadonly(true);
        }

        $forTemplate->Fields->push($searchField);
        $forTemplate->Fields->push($findAction);
        $forTemplate->Fields->push($addAction);
        if ($form = $gridField->getForm()) {
            $forTemplate->Fields->setForm($form);
        }

        $template = 'Forms/DeskallGridFieldAddExistingBlockAutocompleter';
        return array(
            $this->targetFragment => $forTemplate->renderWith($template)
        );
    }
}
