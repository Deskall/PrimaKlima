<?php

/* Delete old ElementForm */

use SilverStripe\Dev\BuildTask;
use DNADesign\ElementalUserForms\Model\ElementForm;
use SilverStripe\UserForms\Model\Recipient\EmailRecipient;
use SilverStripe\UserForms\Model\Submission\SubmittedForm;

class DeleteOldFormElement extends BuildTask
{

    protected $title = 'DeleteOldFormElement';

    protected $description = 'Alle alte Formulare löschen';

    public function run($request)
    {
        $count = 0;
        $newFormsIds = FormBlock::get()->column('ID');
        $forms = ElementForm::get();
        if (!empty($newFormsIds)){
            $forms = $forms->exclude('ID',$newFormsIds);
        }
        foreach ($forms as $form) {
            $form->doArchive();
            $count ++;
        }

        
        echo 'Finished deleting ' . $count . ' forms<br>';
    }
}
