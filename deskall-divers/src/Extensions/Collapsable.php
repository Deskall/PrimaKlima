<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;

class Collapsable extends DataExtension
{

    private static $db = [
        'collapsed' => 'Boolean(0)'
    ];

    public function updateCMSFields(FieldList $fields){
    	$fields->removeByName('collapsed');
        if ($fields->FieldByName('Root.LayoutTab.GlobalLayout')){
            $fields->FieldByName('Root.LayoutTab.GlobalLayout')->push(CheckboxField::create('collapsed',_t('Block.Collapsed','Zusammengebrochen?')));
        }
        else{
            $fields->push(CheckboxField::create('collapsed',_t('Block.Collapsed','Zusammengebrochen?')));
        }
    }

    public function collapse(){
    	$this->owner->collapsed = 1;
    	$this->owner->write();
    }

    public function expand(){
    	$this->owner->collapsed = 0;
    	$this->owner->write();
    }

}