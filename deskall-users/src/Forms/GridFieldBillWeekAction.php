<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldBillWeekAction implements GridField_ColumnProvider, GridField_ActionProvider 
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
        if(!$record->canBill()) return;
        
            $field = GridField_FormAction::create(
                $gridField,
                'bill'.$record->ID,
                '',
                "bill",
                ['RecordID' => $record->ID]
                )->addExtraClass('grid-field__icon-action btn btn-primary font-icon-install btn--icon-large action action-detail')
                        ->setAttribute('title', _t('SiteTree.BUTTONBILL', 'Diese Woche als verrechnet markieren'))
                        ->setDescription(_t('Global.BILL', 'Diese Woche als verrechnet markieren'));  
            
            return $field->Field();
       
    }

    public function getActions($gridField) 
    {
        return ['bill'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'bill') {
            // perform your action here
            $item->Bill();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'verrechnet.'
            );
        }
    }
}