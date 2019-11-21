<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldApproveCookAction implements GridField_ColumnProvider, GridField_ActionProvider 
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
        
       if ($record->Status == "approved" ){
            return _t(__CLASS__.'.isApproved', 'Genehmigt (Auftrag an Koch gesendet)');
        }
        else{
            if (!$record->Mission()->canChooseCook()) return;
            $field = GridField_FormAction::create(
                $gridField,
                'approve'.$record->ID,
                '',
                "approve",
                ['RecordID' => $record->ID]
                )->addExtraClass('grid-field__icon-action font-icon-check-mark-circle btn--icon-large action action-detail')
                        ->setAttribute('title', _t('SiteTree.BUTTONAPPROVE', 'Diese Koch wählen'))
                        ->setDescription(_t('Global.BUTTONAPPROVE', 'Diese Koch wählen'));  
            
            return $field->Field();
        }        

        return ;
    }

    public function getActions($gridField) 
    {
        return ['approve'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'approve') {
            // perform your action here
            $item->Approve();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'genehmigt.'
            );
        }
    }
}