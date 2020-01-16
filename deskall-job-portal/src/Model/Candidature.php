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
        'Candidat' => Candidat::class,
        'Mission' => Mission::class
    ];

    private static $summary_fields = [
        'Candidat.Thumbnail' => ['title' => 'Foto'],
        'Candidat.NiceAddress' => ['title' => 'Personal Angaben'],
        // 'Candidat.NiceJobs' => ['title' => 'Kompetenz / Berufe'],
        // 'Candidat.NiceTyp' => ['title' => 'Küchen Art']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Status'] = _t(__CLASS__.'.Status','Status');
    $labels['Candidat'] = _t(__CLASS__.'.Candidat','Koch');
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
       $fields->addFieldToTab('Root.Main',DropdownField::create('CandidatID','Koch',Candidat::get()->filter('isApproved',1)->map('ID','Title'))->setEmptyString('Koch auswählen'));
       return $fields;
    }

    public function approve(){
        $this->Status = "approved";
        $this->write();
        $this->Mission()->CandidatID = $this->CandidatID;
        $this->Mission()->createContract();
        $this->Mission()->startMission();
        $this->Mission()->write();
       
        $this->Mission()->sendEmailToApprovedCandidat($this->Candidat());
    }

    public function previewLink(){
        return OfferPage::get()->first()->Link().$this->Mission()->Nummer.'/bewerbungen/'.$this->ID;
    }


}