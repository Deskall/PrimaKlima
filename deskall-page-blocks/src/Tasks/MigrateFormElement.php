<?php

/* Migrate ElementForm to DeskallForm */

use SilverStripe\Dev\BuildTask;
use DNADesign\ElementalUserForms\Model\ElementForm;

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

            //Upadte Recipient and Fields
            foreach ($form->fields() as $field) {
                $field->ParentID = $newForm->ID; 
                $field->write();
            }
            foreach ($form->recipients() as $rec) {
                $rec->FormID = $newForm->ID; 
                $rec->write();
            }
            $count ++;
        }
        
        echo 'Finished migrating ' . $count . ' forms<br>';
    }
}
