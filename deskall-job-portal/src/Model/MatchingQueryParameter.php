<?php

use SilverStripe\ORM\DataObject;

class MatchingQueryParameter extends DataObject
{
    private static $db = array(
      'Title' => 'Varchar',
      'Value' => 'Text'
    );

    private static $singular_name = "Matching Tool Suche Parameter";
    
    private static $plural_name = "Matching Tool Suche Parameter";

    private static $has_one = [
        'Parameter' => JobParameter::class,
        'Query' => MatchingQuery::class
    ];

    private static $summary_fields = [
       'Title','Value'
    ];

    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Parameter');
    $labels['Values'] = _t(__CLASS__.'.Values','Wert');

    return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
    }

    public function onAfterWrite(){
        parent::onAfterWrite();
    }



    public function getCMSFields(){
       $fields = parent::getCMSFields();
       return $fields;
    }
}