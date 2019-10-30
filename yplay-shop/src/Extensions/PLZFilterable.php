<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;

class PLZFilterable extends DataExtension
{
    private static $many_many = [
        'FilteredPLZ' => PostalCode::class,
        'ExcludedPLZ' => PostalCode::class
    ];

    public function updateFieldLabels(&$labels){
        $labels['FilteredPLZ'] = 'Nur verfügbar in diesen Ortschaften';
        $labels['ExcludedPLZ'] = 'Nicht verfügbar in diesen Ortschaften';
    }

    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('FilteredPLZ');
        $fields->removeByName('ExcludedPLZ');
        $fields->addFieldsToTab('Root.PLZ',[
            new ListboxField::create('FilteredPLZ',$this->owner->fieldLabels(true)['FilteredPLZ'],PostalCode::get()->map('ID','Code'),$this->owner->FilteredPLZ()),
            new ListboxField::create('ExcludedPLZ',$this->owner->fieldLabels(true)['ExcludedPLZ'],PostalCode::get()->map('ID','Code'),$this->owner->ExcludedPLZ())
        ]);
        $fields->FieldByName('Root.PLZ')->setTitle('Ortschaften');
    }
}