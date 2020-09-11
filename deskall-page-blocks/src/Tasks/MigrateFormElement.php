<?php

/* Migrate ElementForm to DeskallForm */

use SilverStripe\Dev\BuildTask;

class MigrateFormElement extends BuildTask
{

    protected $title = 'MigrateFormElement';

    protected $description = 'Ersetzt Formular BLock durch neuen DeskallForm';

    public function run($request)
    {
        $count = 0;
        $forms = ElementForm::get();
        foreach ($forms as $form) {
            $newForm = new DeskallForm($form->toMap());
            $newForm->write();
            $form->delete();
            $count ++;
        }
        
        echo 'Finished migrating ' . $count . ' forms<br>';
    }
}
