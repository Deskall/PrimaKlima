<?php
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;
use SilverStripe\Forms\GridField\GridField_ActionProvider;
use SilverStripe\Forms\GridField\GridField_FormAction;
use SilverStripe\Control\Controller;
use TractorCow\Fluent\State\FluentState;

class GridFieldDeleteInAllLocalesAction implements GridField_ColumnProvider, GridField_ActionProvider 
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
            'deleteall'.$record->ID,
            '',
            "deleteall",
            ['RecordID' => $record->ID]
        )->addExtraClass('grid-field__icon-action font-icon-trashbin btn--icon-large action action-detail')
                ->setAttribute('title', _t('Locales.DeleteAll', 'in alle Sprachen löschen'))
                ->setDescription(_t('Locales.DeleteAllDESC', 'in alle Sprachen löschen'));  
                return $field->Field();
        return ;
    }

    public function getActions($gridField) 
    {
        return ['deleteall'];
    }

    public function handleAction(GridField $gridField, $actionName, $arguments, $data) 
    {
        $item = $gridField->getList()->byID($arguments['RecordID']);
        if($actionName == 'deleteall') {
            // perform your action here
            if ($item->FilteredLocales()->exists()){
                foreach ($item->FilteredLocales() as $locale) {
                    FluentState::singleton()->withState(function (FluentState $newState) use ($item,$locale) {
                        $newState->setLocale($locale->Locale);
                        $item->delete();
                    });
                }
            }
            else{
                $item->delete();
            }
            // output a success message to the user
            Controller::curr()->getResponse()->setStatusCode(
                200,
                'erfolgreich gelöscht.'
            );
        }
    }
}