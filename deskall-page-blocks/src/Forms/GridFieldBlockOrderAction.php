<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldBlockOrderAction implements GridField_ColumnProvider, GridField_ActionProvider 
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
                'makefirst'.$record->ID,
                '',
                "makefirst",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-mobile btn--icon-large action action-detail')
                ->setAttribute('title', _t('SiteTree.FirstBlock', 'Erst Block'))
                ->setDescription(_t('ParentBlock.BUTTONFIRST', 'Erst block im mobile'));
       
        if ($record->ID == $record->Parent()->getOwnerPage()->FirstBlockID){
            $field->addExtraClass('icon-primary');
        }
        

        return $field->Field();
    }

    public function getActions($gridField) 
    {
        return ['makefirst'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'makefirst') {
            // perform your action here
            $block = $item->Parent()->getOwnerPage();
            $block->FirstBlockID = $item->ID;
            $block->write();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'gespeichert.'
            );
        }
    }
}