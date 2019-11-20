<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Control\Cookie;

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
            new ListboxField('FilteredPLZ',$this->owner->fieldLabels(true)['FilteredPLZ'],PostalCode::get()->map('ID','Code'),$this->owner->FilteredPLZ()),
            new ListboxField('ExcludedPLZ',$this->owner->fieldLabels(true)['ExcludedPLZ'],PostalCode::get()->map('ID','Code'),$this->owner->ExcludedPLZ())
        ]);
        $fields->FieldByName('Root.PLZ')->setTitle('Ortschaften');
    }

    public function shouldDisplay(){
        $display = true;
        //first we check if plz is defined
        $plz = Cookie::get('yplay_plz');
        // $plz = $this->owner->getRequest()->getSession()->get('active_plz');
        if ($plz){
             //then we check if plz exists
            $PostalCode = PostalCode::get()->byId($plz);
            if ($PostalCode){
                //then we apply filter / exclusion
                if ($this->owner->FilteredPLZ()->exists()){
                    $display = $this->owner->FilteredPLZ()->find('ID',$PostalCode->ID);
                }
                if ($this->owner->ExcludedPLZ()->exists()){
                    $display = !$this->owner->ExcludedPLZ()->find('ID',$PostalCode->ID);
                }
            }
        }
        ob_start();
                    print_r('before '.$this->owner->ProductCode." ".$display."\n");
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);
        $this->owner->extend('updateShouldDisplay',$display);
        ob_start();
                    print_r('after '.$this->owner->ProductCode." ".$display."\n");
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result,FILE_APPEND);

        return $display;
    }
}