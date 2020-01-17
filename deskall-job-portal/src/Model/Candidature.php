<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Assets\File;
use setasign\Fpdi\Tcpdf\Fpdi;
use SilverStripe\Assets\Folder;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Security\Security;
use SilverStripe\Security\Permission;

class Candidature extends DataObject
{
    private static $db = array(
        'Content' => 'Text',
        'Status' => 'Varchar'
    );

    private static $singular_name = "Bewerbung";
    private static $plural_name = "Bewerbungen";

    private static $has_one = [
        'Candidat' => Candidat::class,
        'Mission' => Mission::class,
        'CV' => File::class,
        'File' => File::class
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

    public function NiceStatus(){
      switch($this->Status){
        case "created":
          return _t('Candidature.Open','Offen');
        break;
        case "contacted":
          return _t('Candidature.Contacted','Kontaktiert');
        break;
        case "declined":
          return _t('Candidature.Declined','Abgelehnt');
        break;
        case "deleted":
          return _t('Candidature.Deleted','Gelöscht');
        break;
        default:
        return null;
        break;
      }
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }


    public function getFolderName(){
        return $this->Mission()->getFolderName().'/bewerbungen';
    }


    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('MissionID');
       $fields->removeByName('Status');
       $fields->addFieldToTab('Root.Main',DropdownField::create('CandidatID','Koch',Candidat::get()->filter('isApproved',1)->map('ID','Title'))->setEmptyString('Koch auswählen'));
       return $fields;
    }

    public function getConfig(){
        return JobPortalConfig::get()->first();
    }

    public function Link(){
      return OfferPage::get()->first()->Link().'bewerbung/'.$this->ID;
    }

    public function canView($member = null){
      $member = Security::getCurrentUser();
      if ($member){
        if(Permission::check('ADMIN') || $this->Mission()->Customer()->MemberID == $member->ID || $this->CandidatID == $member->ID){
          return true;
        }
      }
      return false;
    }

    public function canDecline(){
      $member = Security::getCurrentUser();
      if ($member){
        if($this->Mission()->Customer()->MemberID == $member->ID && $this->Status != "declined"){
          return true;
        }
      }
      return false;
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

    public function createPDF(){
        $config = $this->getConfig();

      $pdf = new Fpdi();
      $src = dirname(__FILE__).'/../../..'.$config->OfferFile()->getURL();
      $output = dirname(__FILE__).'/../../../assets/Uploads/tmp/angebot_'.$this->ID.'.pdf';

      $pdf->Addfont('Lato','','lato.php');
      $pageCount = $pdf->setSourceFile($src);
      for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Lato','',8);
            $pdf->setXY(8,60);
            $pdf->WriteHTML('<p>Hello</p>');
            
      }
      $pdf->Output($output,'F');
      
      $folder = Folder::find_or_make($this->getFolderName());
      $file = File::create();
      $file->ParentID = $folder->ID;
      $file->setFromLocalFile($output, $this->getFolderName().'/Bewerbung_'.$this->ID.'.pdf');
      $file->write();
      $file->publishSingle();
      $this->FileID = $file->ID;
      $this->write();
    }

    public function sendDeclineEmail($message){
        $config = $this->getConfig();
        $page = MemberProfilePage::get()->first();
        $from = ($config->EmailFrom) ? $config->EmailFrom : SiteConfig::current_site_config()->Email;
        $body = new DBHTMLText();
        $body->setValue($config->AfterRefusalCandidatureEmailBody.$message);
        
        $mail = new MemberEmail($page,$this->Candidat()->Member(),$from,$this->Candidat()->getEmail(),$config->AfterRefusalCandidatureEmailSubject,$body);
        $mail->send();
    }


}