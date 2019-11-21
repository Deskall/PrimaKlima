<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldApproveAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

        if(!$record->canApprove()) return;

        if ($record->isActive){
            return _t(__CLASS__.'.isActive', '<span class="btn btn-primary font-icon-check-mark-circle btn--icon-large">Aktive</span>');
        }
        else if ($record->isApproved ){
            return _t(__CLASS__.'.isApproved', 'Genehmigt');
        }
        elseif ($record->isRefused){
            return _t(__CLASS__.'.isRefused', 'Abegelehnt');
        }
        else{

            $field1 = GridField_FormAction::create(
                $gridField,
                'refuse'.$record->ID,
                '',
                "refuse",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action  font-icon-cancel-circled btn--icon-large action action-detail')
                ->setAttribute('title', _t('SiteTree.BUTTONREFUSE', 'ablehnen'))
                ->setDescription(_t('Global.BUTTONREFUSEDESC', 'ablehnen'));
                
        
          $field2 = GridField_FormAction::create(
            $gridField,
            'approve'.$record->ID,
            '',
            "approve",
            ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-check-mark-circle icon-primary btn--icon-large action action-detail')
                    ->setAttribute('title', _t('SiteTree.BUTTONAPPROVE', 'genehmigen'))
                    ->setDescription(_t('Global.BUTTONAPPROVE', 'genehmigen'));  
            
            return $field1->Field()." ".$field2->Field();
        }        

        return ;
    }

    public function getActions($gridField) 
    {
        return ['approve','refuse'];
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

        if($actionName == 'refuse') {
            // perform your action here
            $item->Refuse();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'abegelehnt.'
            );
        }
    }
}