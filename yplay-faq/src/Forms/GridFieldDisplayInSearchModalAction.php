<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldDisplayInSearchModalAction implements GridField_ColumnProvider, GridField_ActionProvider 
{

    public function augmentColumns($gridField, &$columns) 
    {
        if(!in_array('Actions', $columns)) {
            $columns[] = 'Actions';
        }
    }

    public function getColumnAttributes($gridField, $record, $columnName) 
    {
        return ['class' => 'grid-field__col-compact'];
    }

    public function getColumnMetadata($gridField, $columnName) 
    {
        if($columnName == 'Actions') {
            return ['title' => ''];
        }
    }

    public function getColumnsHandled($gridField) 
    {
        return ['Actions'];
    }

    public function getColumnContent($gridField, $record, $columnName) 
    {
        if(!$record->canEdit()) return;

        if(!$record->canActivate()) return;

        if ($record->DisplayInSearchModal && $record->canDesactivate()){
            $field = GridField_FormAction::create(
                $gridField,
                'removefromsearch'.$record->ID,
                '',
                "removefromsearch",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-search icon-primary btn--icon-large action action-detail')
                ->setAttribute('title', _t('FAQ.REMOVE', 'nicht im Suche Fenster anzeigen'))
                ->setDescription(_t('Global.BUTTONINACTIVEDESC', 'nicht im Suche Fenster anzeigen'));
                return $field->Field();
        }
        if (!$record->DisplayInSearchModal && $record->canActivate()){
          $field = GridField_FormAction::create(
            $gridField,
            'showinsearch'.$record->ID,
            '',
            "showinsearch",
            ['RecordID' => $record->ID]
        )->addExtraClass('grid-field__icon-action font-icon-search btn--icon-large action action-detail')
                ->setAttribute('title', _t('SiteTree.BUTTONACTIVE', 'im Suche Fenster anzeigen'))
                ->setDescription(_t('Global.BUTTONACTIVEDESC', 'im Suche Fenster anzeigen'));  
                return $field->Field();
        }

        

        return ;
    }

    public function getActions($gridField) 
    {
        return ['showinsearch','removefromsearch'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'showinsearch') {
            // perform your action here
            $item->showinsearch();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'wird anzeigen.'
            );
        }

        if($actionName == 'removefromsearch') {
            // perform your action here
            $item->removefromsearch();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'wird nicht anzeigen.'
            );
        }
    }
}