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
        'ContentRefusal' => 'Text',
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
       'Created' => ['title' => 'Erstellt am'],
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
        if ($this->CV()->exists()){
            $folder = Folder::find_or_make($this->getFolderName());
            $this->CV()->ParentID = $folder->ID;
            $this->CV()->write();
            $this->CV()->publishSingle();
        }
    }

    public function onAfterWrite()
    {
        if ($this->isChanged('CVID')){
            $changedFields = $this->getChangedFields();
            $oldFile = File::get()->byId($changedFields['CVID']['before']);
            if ($oldFile){
                $oldFile->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($oldFile->ID));
                $oldFile->delete();
            }
        }
       
        
        parent::onAfterWrite();
       
    }


    public function getFolderName(){
        return $this->Mission()->getFolderName().'/bewerbungen';
    }


    public function getCMSFields()
    {
       $this->createPDF();
       $fields = parent::getCMSFields();
       $fields->removeByName('MissionID');
       $fields->removeByName('Status');
       $fields->addFieldToTab('Root.Main',DropdownField::create('CandidatID','Bewerber',Candidat::get()->map('ID','printTitle'))->setEmptyString('Bewerber auswählen'));
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

    public function canDelete($member = null){
      $member = Security::getCurrentUser();
      if ($member){
        if(Permission::check('ADMIN') || $this->Mission()->Customer()->MemberID == $member->ID){
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
      $output = dirname(__FILE__).'/../../../assets/Uploads/tmp/bewerbung_'.$this->Mission()->Nummer.'_'.$this->Candidat()->printTitle().'.pdf';

      $pdf->Addfont('Lato','','lato.php');
      $pageCount = $pdf->setSourceFile($src);
      for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->SetPrintHeader(false);
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Lato','',8);
            $pdf->setXY(8,8);

            $pdf->WriteHTML($this->renderWith('Includes/CandidatureData'));
            
      }
      $pdf->Output($output,'F');
      
      $folder = Folder::find_or_make($this->getFolderName());
      $file = ($this->File()->exists()) ? $this->File() : File::create();
      $file->ParentID = $folder->ID;
      $file->setFromLocalFile($output, $this->getFolderName().'/Bewerbung_'.$this->ID.'.pdf');
      $file->write();
      $file->publishSingle();
      $this->FileID = $file->ID;
      $this->write();
    }

    public function sendCandidature(){
      $config = $this->getConfig();
      $from = ($config->EmailFrom) ? $config->EmailFrom : SiteConfig::current_site_config()->Email;
      $body = new DBHTMLText();
      $message = '<p><strong>'._t('Candidature.Messagelabel','Bewerbungstext').'</strong></p>'.$this->Content;
      $body->setValue($config->CandidatureEmailBody.$message);
      $companyEmail = ($this->Mission()->Customer()->ContactPersonEmail) ? $this->Mission()->Customer()->ContactPersonEmail : $this->Mission()->Customer()->CompanyEmail;
      $mail = new CandidatureEmail($config,$this,$from,$companyEmail,$config->CandidatureEmailSubject,$body);
      $mail->setBCC($from);
      $mail->send();
    }

    public function sendDeclineEmail($message){
        $this->ContentRefusal = $message;
        $this->write();
        $config = $this->getConfig();
        $from = ($config->EmailFrom) ? $config->EmailFrom : SiteConfig::current_site_config()->Email;
        $body = new DBHTMLText();
        $body->setValue($config->AfterRefusalCandidatureEmailBody.$message);
        
        $mail = new CandidatureEmail($config,$this,$from,$this->Candidat()->getEmail(),$config->AfterRefusalCandidatureEmailSubject,$body);
        $mail->setBCC($from);
        $mail->send();
    }


}