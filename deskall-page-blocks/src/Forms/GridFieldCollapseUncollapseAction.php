<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldCollapseUncollapseAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

        if (!$record->collapsed){
            $field = GridField_FormAction::create(
                $gridField,
                'collapse'.$record->ID,
                '',
                "collapse",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-book-open icon-primary btn--icon-large action action-detail')
                ->setAttribute('title', _t('SiteTree.BUTTONCOLLAPSE', 'Zusammenbrechen'))
                ->setDescription(_t('Global.BUTTONCOLLAPSE', 'zusammenbrechen'));
        }
        else{
          $field = GridField_FormAction::create(
            $gridField,
            'expand'.$record->ID,
            '',
            "expand",
            ['RecordID' => $record->ID]
        )->addExtraClass('grid-field__icon-action font-icon-book btn--icon-large action action-detail')
                ->setAttribute('title', _t('SiteTree.BUTTONEXPAND', 'Erweitern'))
                ->setDescription(_t('Global.BUTTONEXPAND', 'Erweitern'));  
        }

        

        return $field->Field();
    }

    public function getActions($gridField) 
    {
        return ['expand','collapse'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'collapse') {
            // perform your action here
            $item->collapse();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                _t(__CLASS__.'.Collapsed','zusammengebrochen.')
            );
        }

        if($actionName == 'expand') {
            // perform your action here
            $item->expand();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                _t(__CLASS__.'.Expanded','erweitert.')
            );
        }
    }
}