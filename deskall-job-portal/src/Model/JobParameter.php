<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;

class JobParameter extends DataObject
{
    private static $db = array(
      'Title' => 'Varchar'
    );

    private static $singular_name = "Parameter";
    private static $plural_name = "Parameter";

    private static $has_one = [
        'Config' => JobPortalConfig::class
    ];

    private static $has_many = [
        'Values' => JobParameterValue::class
    ];

    private static $summary_fields = [
       'Title'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Parameter');
    $labels['Values'] = _t(__CLASS__.'.Values','Werte');

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
       $fields->removeByName('ConfigID');
       $fields->removeByName('Values');
       return $fields;
    }
}