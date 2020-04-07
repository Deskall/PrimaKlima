<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\NumericField;

class CollapsableTextExtension extends DataExtension {
    private static $db = [
        'CollapseText' => 'Boolean(0)',
        'Limit' => 'Int'
    ];

    public function updafeFieldLabels(&$labels){
        $labels['CollapseText'] = 'Aufklappbar Text?';
        $labels['Limit'] = 'Text Länge';
    }

    public function updateCMSFields(FieldList $fields){
        $fields->insertAfter('BlockVerticalAlignment',CheckboxField::create('CollapseText',$this->owner->fieldLabels()['CollapseText']));
        $fields->insertAfter('CollapseText',NumericField::create('Limit',$this->owner->fieldLabels()['Limit'])->displayIf('CollapseText')->isChecked()->end());
    }

}