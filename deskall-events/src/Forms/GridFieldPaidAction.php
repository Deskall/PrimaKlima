<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldPaidAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

        if(!$record->canMarkAsPaid()) return;
        
        $field = GridField_FormAction::create(
            $gridField,
            'paid'.$record->ID,
            '',
            "paid",
            ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-check-mark-circle icon-primary btn--icon-large action action-detail')
                    ->setAttribute('title', _t('SiteTree.BUTTONPAID', 'ist bezahlt'))
                    ->setDescription(_t('Global.BUTTONPAIDDESC', 'als bezahlt markieren'));  
            
        return $field->Field();
    }

    public function getActions($gridField) 
    {
        return ['paid'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'paid') {
            // perform your action here
            $item->MarkAsPaid();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'als bezahlt markiert.'
            );
        }

    }
}