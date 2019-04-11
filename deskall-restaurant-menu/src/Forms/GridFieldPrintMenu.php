<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldPrintMenu implements GridField_ColumnProvider, GridField_ActionProvider 
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
                'printMenu'.$record->ID,
                '',
                "printmenu",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-print btn--icon-large action action-detail')
                ->setAttribute('title', _t('MenuCarte.Print', 'Menu generieren'))
                ->setDescription(_t('MenuCarte.PrintDescription', 'Menu als PDF generieren'));

        if ($record->LastEdited > $record->File()->LastEdited){
            $field->addExtraClass('icon-primary');
        }

        return $field->Field();
    }

    public function getActions($gridField) 
    {
        return ['printmenu'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
     
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'printmenu') {
          
            $item->printPDF();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'Menu generiert.'
            );
        }
    }
}