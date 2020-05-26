<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldStockAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

        if ($record->isVisible && $record->canDesactivate()){
            $field = GridField_FormAction::create(
                $gridField,
                'soldoff'.$record->ID,
                '',
                "soldoff",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action font-icon-check-mark-circle icon-primary btn--icon-large action action-detail')
                ->setAttribute('title', _t('Product.SOLDOFF', 'als ausverkauft markieren'))
                ->setDescription(_t('Product.SOLDOFF', 'als ausverkauft markieren'));
                return $field->Field();
        }
        if (!$record->isVisible && $record->canActivate()){
          $field = GridField_FormAction::create(
            $gridField,
            'onstock'.$record->ID,
            '',
            "onstock",
            ['RecordID' => $record->ID]
        )->addExtraClass('grid-field__icon-action font-icon-check-mark-circle btn--icon-large action action-detail')
                ->setAttribute('title', _t('Product.ONSTOCK', 'im Lager'))
                ->setDescription(_t('Product.ONSTOCK', 'im Lager'));  
                return $field->Field();
        }

        return ;
    }

    public function getActions($gridField) 
    {
        return ['soldoff','onstock'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'soldoff') {
            // perform your action here
            $item->soldoff();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'ausverkauft.'
            );
        }

        if($actionName == 'onstock') {
            // perform your action here
            $item->onstock();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'im Lager.'
            );
        }
    }
}