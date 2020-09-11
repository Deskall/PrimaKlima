<?php

/* Migrate ElementForm to DeskallForm */

use SilverStripe\Dev\BuildTask;
use DNADesign\ElementalUserForms\Model\ElementForm;
use SilverStripe\UserForms\Model\Recipient\EmailRecipient;

class MigrateFormElement extends BuildTask
{

    protected $title = 'MigrateFormElement';

    protected $description = 'Ersetzt Formular BLock durch neuen DeskallForm';

    public function run($request)
    {
        $count = 0;
        $forms = ElementForm::get();
        foreach ($forms as $form) {
            $data = $form->toMap();
            unset($data['ID']);
            unset($data['ClassName']);
            $newForm = new FormBlock($data);
            $newForm->write();
            $fields = $form->fields();
            $recs = EmailRecipient::get()->filter('FormID',$form->ID);

            //Upadte Recipient and Fields
            foreach ($fields as $field) {
                $field->ParentID = $newForm->ID;
                $field->ParentClass = $newForm->ClassName;
                $field->write();
            }
            foreach ($recs as $rec) {
                $rec->FormID = $newForm->ID;
                $rec->FormClass = $rec->ClassName;
                $rec->write();
            }
            $count ++;
        }
        
        echo 'Finished migrating ' . $count . ' forms<br>';
    }
}
