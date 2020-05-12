<?php

namespace Bak\News\Forms;

use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;

class GridFieldPublishAction implements GridField_ColumnProvider, GridField_ActionProvider 
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

        if(!$record->canPublish()) return;

        if ($record->Status == "published"){
          
            $field = GridField_FormAction::create(
                $gridField,
                'archive'.$record->ID,
                '',
                "archive",
                ['RecordID' => $record->ID]
            )->addExtraClass('grid-field__icon-action  font-icon-cancel-circled btn--icon-large action action-detail')
                ->setAttribute('title', _t('BakNews.Archive', 'Archivieren'));
        }
        else{
            $field = GridField_FormAction::create(
              $gridField,
              'publish'.$record->ID,
              '',
              "publish",
              ['RecordID' => $record->ID]
              )->addExtraClass('grid-field__icon-action font-icon-check-mark-circle icon-primary btn--icon-large action action-detail')
                      ->setAttribute('title', _t('BakNews.Publish', 'Veröffentlichen'));  
        }
        
        return $field->field();
    }

    public function getActions($gridField) 
    {
        return ['archive','publish'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'archive') {
            // perform your action here
            $item->doArchive();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'archiviert.'
            );
        }

        if($actionName == 'publish') {
            // perform your action here
            $item->doPublish();
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'veröffentlicht.'
            );
        }
    }
}