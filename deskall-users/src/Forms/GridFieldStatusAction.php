<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\LabelField;

class GridFieldStatusAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

        if(!$record->canChangeStatus()) return;

        $field = null;

        switch ($record->Status){
            case "created":
            break;
            case "sentToCustomer":
            //Send reminder
            break;
            case "acceptedByCustomer":
            break;
            case "refusedByCustomer":
            //Mail Admin
            break;
            case "refused":
            //Mail Customer
            break;
            case "sentToCook":
            //Upload and Send Contract
            break;
            case "ChooseCook":
             //?
            break;
            case "contractSent":
            //Send reminder
            break;
            case "approved":
            //activate
            break;
        }
        if ($field){
            return $field->Field();
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