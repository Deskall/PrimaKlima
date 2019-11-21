<?php


use SilverStripe\ORM\DataObject;

class JobBranch extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar'
    );

    private static $singular_name = "Bereich";
    private static $plural_name = "Bereiche";


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Bereich');

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

       return $fields;
    }


}