<?php

/* Migrate ElementForm to DeskallForm */

use SilverStripe\Dev\BuildTask;

class MigrateFormElement extends BuildTask
{

    protected $title = 'MigrateFormElement';

    protected $description = 'Ersetzt Formular BLock durch neuen DeskallForm';

    public function run($request)
    {
        // TODO: needs rewriting for multiple elemental areas

        $count = 0;
        foreach ($forms as $form) {
            $pages = $pageType::get()->filter('ElementalAreaID', 0);
            foreach ($pages as $page) {
                $content = $page->Content;
                $page->Content = '';
                // trigger area relations to be setup
                $page->write();
                $area = $page->ElementalArea();
                $element = new ElementContent();
                $element->Title = 'Auto migrated content';
                $element->HTML = $content;
                $element->ParentID = $area->ID;
                $element->write();
            }
            $count += $pages->Count();
            echo 'Migrated ' . $pages->Count() . ' ' . $pageType . ' pages\' content<br>';
        }
        echo 'Finished migrating ' . $count . ' pages\' content<br>';
    }
}
