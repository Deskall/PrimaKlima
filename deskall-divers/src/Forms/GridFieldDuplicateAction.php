<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldDuplicateAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

          $field = GridField_FormAction::create(
            $gridField,
            'duplicate'.$record->ID,
            '',
            "duplicate",
            ['RecordID' => $record->ID]
        )->addExtraClass('grid-field__icon-action font-icon-page-multiple btn--icon-large action action-detail')
                ->setAttribute('title', _t('SiteTree.Duplicate', 'Duplizieren'))
                ->setDescription(_t('Global.BUTTONDUPLIDESC', 'Duplizieren'));  
                return $field->Field();
        

        

        return ;
    }

    public function getActions($gridField) 
    {
        return ['duplicate'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'duplicate') {
            // perform your action here
            $item->duplicate();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'dupliziert.'
            );
        }
    }
}