<?php

use SilverStripe\Control\HTTPResponse;
use SilverStripe\Core\Convert;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm_ItemRequest;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\ORM\DataExtension;
use Bak\News\Models\News;

class GridFieldPublishItemRequestExtension extends DataExtension
{
    public function updateFormActions(FieldList $actions)
    {        
        $record = $this->owner->getRecord();
        if (!$record || $record->ClassName != News::class ) {
            return $actions;
        }
        else if ($record->Status == "published"){
            if ($record->canArchive()){
                $archive = FormAction::create(
                    'doArchive',
                    _t(__CLASS__.'.ARCHIVE', 'Archivieren')
                )
                ->setUseButtonTag(true)
                ->addExtraClass('btn btn-danger font-icon-box');
                // Insert after save
                if ($actions->fieldByName('action_doSave')) {
                    $actions->insertAfter('action_doSave', $archive);
                } else {
                    $actions->push($archive);
                }
            }
        }
        else{
            if ($record->ID > 0){
                if ($record->canPublish()){
                    $publish = FormAction::create(
                        'doPublish',
                        _t(__CLASS__.'.PUBLISH', 'Veröffentlichen')
                    )
                    ->setUseButtonTag(true)
                    ->addExtraClass('btn btn-primary font-icon-rocket');
                    // Insert after save
                    if ($actions->fieldByName('action_doSave')) {
                        $actions->insertAfter('action_doSave', $publish);
                    } else {
                        $actions->push($publish);
                    }
                }
            }
            
        }
       
        return $actions;
    }
   
    public function doPublish($data, $form)
    {
       
        $record = $this->owner->getRecord();
        if (!$record->canPublish()) {
            return $this->owner->httpError(403);
        }
      
        $record->doPublish();
        $message = _t(
            __CLASS__ . '.NewsPublished',
            'News {title} wurde veröffentlicht',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }

    public function doArchive($data, $form)
    {
       
        $record = $this->owner->getRecord();
        if (!$record->canArchive()) {
            return $this->owner->httpError(403);
        }
      
        $record->doArchive();
        $message = _t(
            __CLASS__ . '.NewsArchived',
            'News {title} wurde archiviert',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }
    
    /**
     * @param Form $form
     * @param string $message
     */
    protected function setFormMessage($form, $message)
    {
        $form->sessionMessage($message, 'good', ValidationResult::CAST_HTML);
        $controller = $this->getToplevelController();
        if ($controller->hasMethod('getEditForm')) {
            /** @var Form $backForm */
            $backForm = $controller->getEditForm();
            $backForm->sessionMessage($message, 'good', ValidationResult::CAST_HTML);
        }
    }

    protected function getToplevelController()
    {
        $c = $this->owner->popupController;
        while ($c && $c instanceof GridFieldDetailForm_ItemRequest) {
            $c = $c->getController();
        }
        return $c;
    }

    protected function redirectAfterSave($isNewRecord)
    {
        $controller = $this->getToplevelController();
        if ($isNewRecord) {
            return $controller->redirect($this->Link());
        } elseif ($this->owner->gridField->getList()->byID($this->record->ID)) {
            // Return new view, as we can't do a "virtual redirect" via the CMS Ajax
            // to the same URL (it assumes that its content is already current, and doesn't reload)
            return $this->owner->edit($controller->getRequest());
        } else {
            // Changes to the record properties might've excluded the record from
            // a filtered list, so return back to the main view if it can't be found
            $url = $controller->getRequest()->getURL();
            $noActionURL = $controller->removeAction($url);
            $controller->getRequest()->addHeader('X-Pjax', 'Content');
            return $controller->redirect($noActionURL, 302);
        }
    }
}