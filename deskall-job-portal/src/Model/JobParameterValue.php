<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;

class JobParameterValue extends DataObject
{
    private static $db = array(
      'Title' => 'Varchar'
    );

    private static $singular_name = "Parameter Wert";
    private static $plural_name = "Parameter Werte";

    private static $has_one = [
        'Parameter' => JobParameter::class
    ];


    private static $summary_fields = [
       'Title'
    ];

    private static $extensions = [
        'Sortable',
        'Activable'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Parameter');

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
       $fields->removeByName('ParameterID');
       return $fields;
    }

    public function activeOffers(){
      $missionIds = AssignedJobParameter::get()->filter('Title',$this->Parameter()->Title,'Value' => $this->Title)->column('MissionID');
      return Mission::get()->filter(['isActive' => 1, 'ID' => $missionIds]);
    }
}