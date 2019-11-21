<?php

use SilverStripe\ORM\DataObject;

class CookJobOption extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'HourPay' => 'Varchar',
        'HourPayCustomer' => 'Varchar'
    );

    private static $singular_name = "Küche Beruf Option";
    private static $plural_name = "Küche Beruf Optionen";

    private static $has_one = [
        'Job' => CookJob::class
    ];

    private static $summary_fields = [
        'Title',
        'HourPay',
        'HourPayCustomer'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Option');
    $labels['Job'] = _t(__CLASS__.'.Job','Beruf');
    $labels['HourPay'] = _t(__CLASS__.'.HourPay','Stundensatz (Koch)');
    $labels['HourPayCustomer'] = _t(__CLASS__.'.HourPayCustomer','Stundensatz (Kunde)');

    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('JobID');
       return $fields;
    }


}