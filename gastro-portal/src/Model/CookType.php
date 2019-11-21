<?php


use SilverStripe\ORM\DataObject;

class CookType extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar'
    );

    private static $singular_name = "Küche Art";
    private static $plural_name = "Küche Art";

    private static $belongs_many_many = [
        'Cooks' => Cook::class
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Küche Art');
    $labels['Cooks'] = _t(__CLASS__.'.Cooks','Köche');

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
       $fields->removeByName('Cooks');

       return $fields;
    }


}