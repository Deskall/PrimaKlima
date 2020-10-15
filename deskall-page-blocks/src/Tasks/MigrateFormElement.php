<?php

/* Migrate ElementForm to DeskallForm */

use SilverStripe\Dev\BuildTask;
use DNADesign\ElementalUserForms\Model\ElementForm;
use SilverStripe\UserForms\Model\Recipient\EmailRecipient;
use SilverStripe\UserForms\Model\Submission\SubmittedForm;

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
            if ($newForm->RedirectPageID == 0){
                $newForm->RedirectPageID = HomePage::get()->first()->ID;
            }
            $newForm->write();
            $fields = $form->fields();
            $recs = EmailRecipient::get()->filter('FormID',$form->ID);
            $subms = SubmittedForm::get()->filter('ParentID',$form->ID);

            //Upadte Recipient and Fields and Submissions
            foreach ($fields as $field) {
                $field->ParentID = $newForm->ID;
                $field->ParentClass = $newForm->ClassName;
                $field->write();
            }
            foreach ($recs as $rec) {
                $rec->FormID = $newForm->ID;
                $rec->FormClass = $newForm->ClassName;
                $rec->write();
            }
            foreach ($subms as $sub) {
                $sub->ParentID = $newForm->ID;
                $sub->ParentClass = $newForm->ClassName;
                $sub->write();
            }
            // $form->delete();
            // $newForm->publishSingle();
            //Publish page
            $newForm->getRealPage()->publishRecursive();
            $count ++;
        }

        $forms->removeAll();
        
        echo 'Finished migrating ' . $count . ' forms<br>';
    }
}
