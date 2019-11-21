<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;

class Candidature extends DataObject
{
    private static $db = array(
      'Status' => 'Varchar'
    );

    private static $singular_name = "Bewerbung";
    private static $plural_name = "Bewerbungen";

    private static $has_one = [
        'Cook' => Cook::class,
        'Mission' => Mission::class
    ];

    private static $summary_fields = [
        'Cook.Thumbnail' => ['title' => 'Foto'],
        'Cook.NiceAddress' => ['title' => 'Personal Angaben'],
        'Cook.NiceJobs' => ['title' => 'Kompetenz / Berufe'],
        'Cook.NiceTyp' => ['title' => 'Küchen Art']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Status'] = _t(__CLASS__.'.Status','Status');
    $labels['Cook'] = _t(__CLASS__.'.Cook','Koch');
    $labels['Mission'] = _t(__CLASS__.'.Mission','Auftrag');

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
       $fields->removeByName('MissionID');
       $fields->removeByName('Status');
       $fields->addFieldToTab('Root.Main',DropdownField::create('CookID','Koch',Cook::get()->filter('isApproved',1)->map('ID','Title'))->setEmptyString('Koch auswählen'));
       return $fields;
    }

    public function approve(){
        $this->Status = "approved";
        $this->write();
        $this->Mission()->CookID = $this->CookID;
        $this->Mission()->createContract();
        $this->Mission()->startMission();
        $this->Mission()->write();
       
        $this->Mission()->sendEmailToApprovedCook($this->Cook());
    }


}