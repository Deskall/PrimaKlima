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


class MissionGridFieldItemRequestExtension extends DataExtension
{
    public function updateFormActions(FieldList $actions)
    {        
        $record = $this->owner->getRecord();
        if (!$record || $record->ClassName != "Mission" ) {
            return $actions;
        }
        else if ($record->isActive){
            if ($record->canClose()){
                $close = FormAction::create(
                    'doCloseOffer',
                    _t(__CLASS__.'.BUTTONCLOSEOFFER', 'Auftrag schliessen')
                )
                ->setUseButtonTag(true)
                ->addExtraClass('btn btn-primary font-icon-box');
                // Insert after save
                if ($actions->fieldByName('action_doSave')) {
                    $actions->insertAfter('action_doSave', $close);
                } else {
                    $actions->push($close);
                }
            }
        }
        else{
            if ($record->ID > 0){
                if ($record->backend){
                    switch ($record->Status){
                        case "new":
                            $send = FormAction::create(
                                'doCreateOffer',
                                _t(__CLASS__.'.BUTTONCREATEOFFER', 'Auftrag erstellen')
                            )
                            ->setUseButtonTag(true)
                            ->addExtraClass('btn btn-primary font-icon-clipboard-pencil');
                            // Insert after save
                            if ($actions->fieldByName('action_doSave')) {
                                $actions->insertAfter('action_doSave', $send);
                            } else {
                                $actions->push($send);
                            }
                        break;
                        case "created":
                            $send = FormAction::create(
                                'doSendOfferEmail',
                                _t(__CLASS__.'.BUTTONSENDOFFEREMAIL', 'Auftrag an Kunde senden')
                            )
                            ->setUseButtonTag(true)
                            ->addExtraClass('btn btn-primary font-icon-export');
                            // Insert after save
                            if ($actions->fieldByName('action_doSave')) {
                                $actions->insertAfter('action_doSave', $send);
                            } else {
                                $actions->push($send);
                            }
                            $activate = FormAction::create(
                                'doActivateOffer',
                                _t(__CLASS__.'.BUTTONACTIVATEOFFER', 'Auftrag bestätigen (wird für Köche sichtbar)')
                            )
                            ->setUseButtonTag(true)
                            ->addExtraClass('btn btn-primary font-icon-check-mark-circle');

                            // $confirm = FormAction::create(
                            //     'doConfirmOffer',
                            //     _t(__CLASS__.'.BUTTONCONFIRMOFFER', 'Auftrag an Köche senden')
                            // )
                            // ->setUseButtonTag(true)
                            // ->addExtraClass('btn btn-primary font-icon-rocket');
                            // Insert after save
                            if ($actions->fieldByName('action_doSave')) {
                                $actions->insertAfter('action_doSave', $send);
                                $actions->insertAfter('action_doSendOfferEmail', $activate);
                                // $actions->insertAfter('action_doActivateOffer', $confirm);
                            } else {
                                $actions->push($send);
                                $actions->push($activate);
                                // $actions->push($confirm);
                            }
                        break;
                        case "acceptedByCustomer":
                            $confirm = FormAction::create(
                                'doConfirmOffer',
                                _t(__CLASS__.'.BUTTONCONFIRMOFFER', 'Auftrag an Köche senden')
                            )
                            ->setUseButtonTag(true)
                            ->addExtraClass('btn btn-primary font-icon-rocket');
                            // Insert after save
                            if ($actions->fieldByName('action_doSave')) {
                                $actions->insertAfter('action_doSave', $confirm);
                            } else {
                                $actions->push($confirm);
                            }
                        break;
                    }
                }
                else{
                    if ($record->hasMethod('canSendEmail') && $record->canSendEmail()) {
                        $send = FormAction::create(
                            'doSendEmail',
                            _t(__CLASS__.'.BUTTONSENDEMAIL', 'Auftrag an Köche senden')
                        )
                            ->setUseButtonTag(true)
                            ->addExtraClass('btn btn-primary font-icon-rocket');
                        // Insert after save
                        if ($actions->fieldByName('action_doSave')) {
                            $actions->insertAfter('action_doSave', $send);
                        } else {
                            $actions->push($send);
                        }
                    }
                }
            }
            
        }
       
        return $actions;
    }
   
    public function doSendEmail($data, $form)
    {
       
        $record = $this->owner->getRecord();
        if (!$record->canSendEmail()) {
            return $this->owner->httpError(403);
        }
      
        $record->sendEmailToCooks();
        $message = _t(
            __CLASS__ . '.EmailSent',
            'Auftrag {title} an alle Köche wieder gesendet',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }

    public function doSendOfferEmail($data, $form)
    {
       
        $record = $this->owner->getRecord();
        
        $record->sendOfferMail();
        $record->Status = "sentToCustomer";
        $record->write();
        $message = _t(
            __CLASS__ . '.EmailOfferSent',
            'Auftrag {title} an Kunde gesendet',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }
    
    public function doActivateOffer($data, $form){
        $record = $this->owner->saveFormIntoRecord($data, $form);
        
        $record->show();
        $record->Status = "confirmedByCustomer";
        $message = _t(
            __CLASS__ . '.OfferActivated',
            'Auftrag {title} bestätigt und sichtbar',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }

    public function doConfirmOffer($data, $form)
    {
       
        //$record = $this->owner->getRecord();
        $record = $this->owner->saveFormIntoRecord($data, $form);
        
        $record->confirmedByCustomer();
        $message = _t(
            __CLASS__ . '.OfferConfirmed',
            'Auftrag {title} bestätigt und an Köche gesendet',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }

    public function doCreateOffer($data, $form)
    {
        $record = $this->owner->saveFormIntoRecord($data, $form);
        $record->Price = $record->calculatePrice();
        $record->createOffer();
        $record->Status = "created";
        $record->write();
        $message = _t(
            __CLASS__ . '.OfferCreated',
            'Auftrag {title} erstellt',
            [
                'title' => Convert::raw2xml($record->Title)
            ]
        );
        $this->setFormMessage($form, $message);
        return $this->redirectAfterSave(false);
    }

    public function doCloseOffer($data, $form){
        $record = $this->owner->saveFormIntoRecord($data, $form);
        
        $record->close();
        $record->Status = "closed";
        $message = _t(
            __CLASS__ . '.OfferClosed',
            'Auftrag {title} geschliessen',
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