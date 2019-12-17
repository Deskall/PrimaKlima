<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Security\DefaultAdminService;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Group;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\Assets\Upload;
use SilverStripe\ORM\DB;
use SilverStripe\Security\RandomGenerator;
use SilverStripe\Security\Security;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\CheckboxSetField;
use setasign\Fpdi\Tcpdf\Fpdi;
use SilverStripe\Security\Permission;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Forms\RequiredFields;

class Mission extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'Place' => 'Varchar',
        'Period' => 'Varchar',
        'Start' => 'Date',
        'End' => 'Date',
        'Position' => 'Varchar',
        'Description' => 'HTMLText',
        'Status' => 'Varchar',
        'AdminComments' => 'HTMLText',
        'OfferKey' => 'Varchar',
        'Company' => 'Varchar',
        'Surname' => 'Varchar',
        'FirstName' => 'Varchar', 
        'Email'  => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'Fax'  => 'Varchar',
        'URL'  => 'Varchar',
        'SentDate' => 'Date',
        'SentContractDate' => 'Date',
        'backend' => 'Boolean(0)',
        'isActive' => 'Boolean(0)',
        'isClosed' => 'Boolean(0)'
    );

    private static $singular_name = "Stelle";
    private static $plural_name = "Stellen";

    private static $default_sort = ['Created' => 'DESC'];

    private static $extensions = [
        Activable::class,
        Sortable::class,
        SubObjectPermission::class
    ];

    private static $has_one = [
        'Customer' => JobGiver::class,
        'Candidat' => Candidat::class,
        'OfferFile' => File::class,
        'ContractFile' => File::class
    ];

    private static $owns = ['OfferFile','ContractFile','Candidatures'];

    private static $has_many = [
        'Candidatures' => Candidature::class
    ];


    private static $summary_fields = [
        'Created' => ['title' => 'Erstellt am']
        
    ];

    private static $searchable_fields = [
        'Title',
        'Customer.Title'
    ];

    private static $status_types = [
        "new" => "Neu",
        "draft" => "Entwurf",
        "published" => "Veröffentlicht",
        "archived" => "Archiviert"
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Titel');
    $labels['Customer'] = _t(__CLASS__.'.Customer','Kunde');
    $labels['Position'] = _t(__CLASS__.'.Position','Position');
    $labels['Description'] = _t(__CLASS__.'.Description','Beschreibung');
    $labels['Status'] = _t(__CLASS__.'.Status','Status');
    $labels['Candidat'] = _t(__CLASS__.'.Candidat','Mietkoch');
    $labels['Candidatures'] = _t(__CLASS__.'.Candidatures','Bewerbungen');
    $labels['AdminComments'] = _t(__CLASS__.'.AdminComments','Bemerkungen (Admin)');
    $labels['Place'] = _t(__CLASS__.'.Place','Ort / Einrichtung');
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Email'] = _t(__CLASS__.'.Email','E-Mail-Adresse');
    $labels['Options'] = _t(__CLASS__.'.Options','Optionen');
    $labels['Candidatures'] = _t(__CLASS__.'.Candidatures','Bewerbungen');
    $labels['Job'] = _t(__CLASS__.'.Job','Position');
    $labels['Start'] = _t(__CLASS__.'.Start','Anfang');
    $labels['End'] = _t(__CLASS__.'.End','Ende');
    $labels['Surname'] = _t(__CLASS__.'.Surname','Name');
    $labels['FirstName'] = _t(__CLASS__.'.FirstName','Vorname');

    return $labels;
    }

    

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        // if ($this->ID == 0){
        //     $this->isVisible = 0;
        // }
        // if (!$this->OfferKey){
        //     $this->OfferKey = $this->generateToken();
        // }
        // if ($this->Start && $this->End){
        //     $this->Period = _t('Mission.From','von').' '.date('d.m.Y',strtotime($this->Start)).' '._t('Mission.Until','bis').' '.date('d.m.Y',strtotime($this->End));
        // }
        // if ($this->Status == "created" && $this->isVisible){
        //     $this->Status = "acceptedByCustomer";
        // }
        // if ($this->backend){
        //     if (!$this->Status){
        //         $this->Status = "new";
        //     }
        //     $member = Member::get()->filter('Email' , $this->Email)->first();
        //     if (!$member){
        //         $member = new Member();
        //         $member->Surname = $this->Surname;
        //         $member->FirstName = $this->FirstName;
        //         $member->Email = $this->Email;
        //         $member->write();
        //         $member->addToGroupByCode('kunden');
        //     }
        //     $customer =  Customer::get()->filter('MemberID' , $member->ID)->first();
        //     if (!$customer){
        //         $customer = Customer::create();
        //     }
        //         $customer->Surname = $this->Surname;
        //         $customer->FirstName = $this->FirstName;
        //         $customer->Email = $this->Email;
        //         $customer->Company = $this->Company;
        //         $customer->Gender = $this->Gender;
        //         $customer->Address = $this->Address;
        //         $customer->PostalCode = $this->PostalCode;
        //         $customer->City = $this->City;
        //         $customer->Country = $this->Country;
        //         $customer->Phone = $this->Phone;
        //         $customer->Fax = $this->Fax;
        //         $customer->URL = $this->URL;
        //         $customer->MemberID = $member->ID;
        //         $customer->write();
            
        //     $this->CustomerID = $customer->ID;
        //     $this->Price = $this->calculatePrice();
        //     $this->CustomerPrice = $this->calculateCustomerPrice();
        // }
    }

    public function onAfterWrite()
    {
        parent::onAfterWrite(); 
        // if ($this->isChanged('Start')){
        //     //then we reset the weeks
        //     foreach ($this->Weeks() as $week) {
        //       $week->delete();
        //     }
        //     $this->Weeks()->removeAll();
        //     $this->ManageWeeks();  
        // } 
        // else if ($this->isChanged('End')){
        //     $this->ManageWeeks();   
        // }

    }

    public function onBeforeDelete(){
        parent::onBeforeDelete();
        // if ($this->OfferFile()->exists()){
        //     $this->OfferFile()->File->deleteFile();
        //     DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($this->OfferFile()->ID));
        //     $this->OfferFile()->delete();
        // }
        // //delete folder
        // $folder = Folder::find_or_make("Uploads/Auftraege/".$this->ID);
        // $folder->File->deleteFile();
        // DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($folder->ID));
        // $folder->delete();
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       // $fields = FieldList::create(
       //      Tabset::create('Root',
       //          Tab::create('Main','Aufrage Daten',
       //              HiddenField::create('backend')->setValue(true),
       //              HiddenField::create('Status'),
       //              CompositeField::create(
       //                  // TextField::create('Title',$this->fieldLabels(true)['Title']),
       //                  DropdownField::create('JobID',$this->fieldLabels(true)['Job'], JobReference::get()->map('ID','Title'))->setEmptyString('Position Wählen'),
       //                  TextField::create('Place',$this->fieldLabels(true)['Place']),
       //                  TextField::create('URL',$this->fieldLabels(true)['URL']),
       //                  FieldGroup::create(
       //                      $start = DateField::create('Start',$this->fieldLabels()['Start']),
       //                      DateField::create('End',$this->fieldLabels()['End'])
       //                  ),
       //                  HTMLEditorField::create('Access',$this->fieldLabels(true)['Access'])->setRows(3),
       //                  HTMLEditorField::create('Others',$this->fieldLabels(true)['Others'])->setRows(3)
       //              )->setName('MissionDaten')->setTitle('Auftrag Angaben'),
       //              CompositeField::create(
       //                  TextField::create('Company',$this->fieldLabels(true)['Company']),
       //                  TextField::create('Surname',$this->fieldLabels(true)['Surname']),
       //                  TextField::create('FirstName',$this->fieldLabels(true)['FirstName']),
       //                  EmailField::create('Email',$this->fieldLabels(true)['Email']),
       //                  TextField::create('Address',$this->fieldLabels(true)['Address']),
       //                  TextField::create('PostalCode',$this->fieldLabels(true)['PostalCode']),
       //                  TextField::create('City',$this->fieldLabels(true)['City']),
       //                  DropdownField::create('Country',$this->fieldLabels(true)['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')),
       //                  TextField::create('Phone',$this->fieldLabels(true)['Phone']),
       //                  TextField::create('Fax',$this->fieldLabels(true)['Fax'])
       //              )->setName('CustomerDaten')->setTitle('Kunde Angaben'),
       //              HTMLEditorField::create('AdminComments',$this->fieldLabels(true)['AdminComments'])->setRows(5)
       //         ),
       //          Tab::create('Candidatures',$this->fieldLabels(true)['Candidatures']),
       //          Tab::create('Weeks',$this->fieldLabels(true)['Weeks'])
       //      )
       //  );
       // if ($this->ID > 0){
       //  //Options
       //  if ($this->Job()->Options()->exists()){
       //      $options = CheckboxSetField::create('Options-'.$this->Job()->ID,'Optionen',$this->Job()->Options()->map('ID','Title')->toArray(), $this->Options());
       //      $fields->insertAfter('JobID',$options);
       //  }
       //  //Candidatures
       //    $Candidatures = GridField::create('Candidatures',$this->fieldLabels(true)['Candidatures'],$this->Candidatures(),GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldApproveCandidatAction()));
       //     $fields->addFieldToTab('Root.Candidatures',$Candidatures);

       //  //Weeks
       //    $Weeks = GridField::create('Weeks',$this->fieldLabels(true)['Weeks'],$this->Weeks(),GridFieldConfig_Base::create()->addComponent(new GridFieldBillWeekAction()));
       //     $fields->addFieldToTab('Root.Weeks',$Weeks);
       // }
       // if ($this->OfferFile()->exists()){
       //  $fields->insertBefore('MissionDaten',LiteralField::create('OfferDownload','<a href="'.$this->OfferFile()->getURL().'" target="_blank" class="btn action btn btn-primary font-icon-print">Angebot herunterladen</a>'));
       // }

       // if ($this->Start && $this->Start < date('Y-m-d')){
       //  $fields->replaceField('Start', $start->performReadonlyTransformation());
       // }
       

       return $fields;
    }

    public function getFormFields(){
        $customer = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
        $fields = FieldList::create(
            HiddenField::create('CustomerID')->setValue($customer->ID),
            TextField::create('Title',$this->fieldLabels()['Title']),
            $parameters = CompositeField::create()->setName('ParametersFields'),
            DateField::create('Start',$this->fieldLabels()['Start']),
            DateField::create('End',$this->fieldLabels()['End']),
            HTMLEditorField::create('Description',$this->fieldLabels()['Description'])
        );

        $config = $this->getJobConfig();
        foreach ($config->Parameters() as $p) {
           $field = DropdownField::create($p->Title,$p->Title,$p->Values()->map('ID','Title'));
           $parameters->push($field);
        }

        return $fields;
    }

    public function getRequiredFields(){
        return new RequiredFields(['Title','Description']);
    }

    /**
     * @return null|string
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \SilverStripe\ORM\ValidationException
     */
    public function getCMSEditLink()
    {
        $admin = Injector::inst()->get(UserAdmin::class);

        // Classname needs to be passeed as an action to ModelAdmin
        $classname = str_replace('\\', '-', $this->ClassName);

        return Controller::join_links(
            $admin->Link($classname),
            "EditForm",
            "field",
            $classname,
            "item",
            $this->ID,
            "edit"
        );
    }

    public function previewLink(){
        return ($this->getJobsPage()->exists()) ? $this->getJobsPage()->Link().'details/'.$this->ID : null;
    }

    public function getJobsPage(){
        return OfferPage::get()->first();
    }

    public function getJobConfig(){
        return JobPortalConfig::get()->first();
    }


     public function canEdit($member = null){
        if ($this->isClosed){
            return false;
        }
        else{
            return parent::canEdit($member);
        }
    }

    public function canDelete($member = null){
        if ($this->isActive){
            return false;
        }
        else{
            return parent::canDelete($member);
        }
    }

    

    public function generateToken(){
        $generator = new RandomGenerator();
        $token = $generator->randomToken();
        while (Mission::get()->filter('OfferKey',$token)->count() > 0){
            $token = $generator->randomToken();
        }
        return $token;
    }


    public function CountCandidatures(){
        return $this->Candidatures()->count();
    }

   

    // //Price calculation
    // public function calculatePrice(){
    //     if ($this->Job()->exists()){
    //         $hourPay = floatval($this->Job()->HourPay);
    //         if ($this->Options()->exists()){
    //             foreach ($this->Options() as $opt) {
    //                $hourPay += floatval($opt->HourPay);
    //             }
    //         }
    //         $hourPay = (string) $hourPay." €";
    //         if ($this->Customer()->exists()){
    //             //To do
    //            // $hourPayDiscount = XX;
    //             //$hourPay -= $hourPayDiscount; 
    //         }
    //         return $hourPay;
    //     }
    //     return null;
    // }

    //  public function calculateCustomerPrice(){
    //     if ($this->Job()->exists()){
    //         $hourPay = floatval($this->Job()->HourPayCustomer);
    //         if ($this->Options()->exists()){
    //             foreach ($this->Options() as $opt) {
    //                $hourPay += floatval($opt->HourPayCustomer);
    //             }
    //         }
    //         $hourPay = (string) $hourPay." €";
    //         if ($this->Customer()->exists()){
    //             //To do
    //            // $hourPayDiscount = XX;
    //             //$hourPay -= $hourPayDiscount; 
    //         }
    //         return $hourPay;
    //     }
    //     return null;
    // }

    // public function canChangeStatus(){
    //     return true;
    // }

    public function canCandidate(){
        $member = Security::getCurrentUser();
        if ($member){
            $Candidat = Candidat::get()->filter('MemberID',$member->ID)->first();
            if ($Candidat && $Candidat->Status == "approved"){
              if (!Candidature::get()->filter(['CandidatID' => $Candidat->ID, 'MissionID' => $this->ID])->first()){
                    return true;
                }  
            }
        }
        return false;
    }

    public function canSendEmail(){
        return (Permission::check('ADMIN') && $this->isVisible);
    }

    // public function canChooseCandidat(){
    //     return !$this->Candidatures()->filter('Status','approved')->exists();
    // }

    // public function canClose(){
    //     return !$this->Weeks()->exclude('isBilled',1)->exists();
    // }


    //STEPS
    public function confirmedByCustomer(){
        $this->Status = "acceptedByCustomer";
        //$this->sendEmailToCandidats();
        //$this->Status = "sentToCandidat";
        $this->write();
    }

    public function confirmedByCandidat(){
        $this->sendEndConfirmationEmails();
        $this->Status = "approved";
        $this->write();
    }
    

    public function createOffer(){
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
            $pdf->WriteHTML($this->parseString($config->Intro));
            $y = $pdf->GetY();
            $i = 6;
            $pdf->setXY(10,$y + $i);
            $pdf->SetFont('Stone sans ITC','',10);
            $pdf->WriteHTML("Angebot:");
            $pdf->SetFont('Lato','',8);
            $pdf->setXY(10,$y + $i*2);
            $pdf->WriteHtml("Einsatz:");
            $pdf->setXY(50,$y + $i*2);
            $pdf->WriteHtml($config->Usage);
            $pdf->setXY(10,$y + $i*3);
            $pdf->WriteHtml("Funktion:");
            $pdf->setXY(50,$y + $i*3);
            $pdf->WriteHtml($this->NiceJobTitle());
            $pdf->setXY(10,$y + $i*4);
            $pdf->WriteHtml("Einsatzzeitraum:");
            $pdf->setXY(50,$y + $i*4);
            $pdf->WriteHtml($this->Period);
            $pdf->setXY(10,$y + $i*5);
            $pdf->WriteHtml("Kosten:");
            $pdf->setXY(50,$y + $i*5);
            $pdf->WriteHtml($this->CustomerPrice." pro Std., mindestens 8 Std. pro Tag, 50% Zuschläge an Sonn-und Feiertagen");
            $pdf->setXY(10,$y + $i*6);
            $pdf->WriteHtml("Fahrtkosten:");
            $pdf->setXY(50,$y + $i*6);
            $pdf->WriteHtml($config->TransportCost);
            $pdf->setXY(10,$y + $i*7);
            $pdf->WriteHtml("Kost&Logis:");
            $pdf->setXY(50,$y + $i*7);
            $pdf->WriteHtml($config->CostAndHousing);
            $pdf->setXY(10,$y + $i*8);
            $pdf->WriteHtml("Agentur-Gebühr:");
            $pdf->setXY(50,$y + $i*8);
            $pdf->WriteHtml($config->AgentCost);

            $pdf->setXY(8,$y + $i*10);
            $pdf->WriteHTML($this->parseString($config->Diverse));
            $y = $pdf->GetY();
            $pdf->setXY(8,$y + $i);
            $pdf->WriteHTML($this->parseString($config->Conditions));
             $y = $pdf->GetY();
            $pdf->setXY(10,$y + $i);
            $pdf->WriteHtml("Datum: ".date('d.m.Y'));
            $pdf->setXY(150,$y + $i);
            $pdf->WriteHtml("Kunde Unterschrift: ");
      }
      $pdf->Output($output,'F');
      


      $tmpFolder = "Uploads/Auftraege/".$this->ID;
      $folder = Folder::find_or_make($tmpFolder);
      $file = File::create();
      $file->ParentID = $folder->ID;
      $file->setFromLocalFile($output, 'Uploads/Auftraege/'.$this->ID.'/Angebot.pdf');
      $file->write();
      $file->publishSingle();
      $this->OfferFileID = $file->ID;
      $this->write();
      
    }

    /* create Contract as PDF */
    public function createContract(){
      $config = $this->getConfig();

      $pdf = new Fpdi();
      $src = dirname(__FILE__).'/../../..'.$config->ContractFile()->getURL();
      $output = dirname(__FILE__).'/../../../assets/Uploads/tmp/auftrag_'.$this->ID.'.pdf';

      $pdf->Addfont('Stone sans ITC','','stonesansitc.php');
      $pdf->Addfont('Lato','','lato.php');
      $pageCount = $pdf->setSourceFile($src);
      for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Lato','',8);
            $pdf->setXY(8,60);
            $pdf->WriteHTML($this->parseString($config->ChosenCandidatEmailBody));
            $y = $pdf->GetY();
            $pdf->setXY(10,$y + 20);
            $pdf->WriteHtml("Datum: ".date('d.m.Y'));
            $pdf->setXY(150,$y + 20);
            $pdf->WriteHtml("Ihre Unterschrift: ");
      }
      $pdf->Output($output,'F');
      


      $tmpFolder = "Uploads/Auftraege/".$this->ID;
      $folder = Folder::find_or_make($tmpFolder);
      $file = File::create();
      $file->ParentID = $folder->ID;
      $file->setFromLocalFile($output, 'Uploads/Auftraege/'.$this->ID.'/Auftrag.pdf');
      $file->write();
      $file->publishSingle();

      $this->ContractFileID = $file->ID;
      $this->write();
      
    }



    public function getConfig(){
        return JobPortalConfig::get()->first();
    }

    public function CustomerTitle(){
        return $this->Customer()->Gender." ".ucfirst($this->Customer()->Member()->FirstName)." ".ucfirst($this->Customer()->Member()->Surname);
    }

    public function CandidatTitle(){
        return $this->Candidat()->Gender." ".ucfirst($this->Candidat()->Member()->FirstName)." ".ucfirst($this->Candidat()->Member()->Surname);
    }


    public function parseString($string)
    {
        $date = new \DateTime($this->SentDate);
        $variables = array(
            '$Customer.Title' => $this->CustomerTitle(),
            '$SentDate' => $date->Format('d.m.Y'),
            '$Candidat.Title' => $this->CandidatTitle(),
            '$Customer.Data' => $this->renderWith('Emails/CustomerData'),
            '$Candidat.ApprovalLink' => $this->CandidatApprovalLink(),
            '$Mission.Data' => $this->renderWith('Emails/MissionData')
        );
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }
    
    //EMAILS
    public function sendOfferMail(){
        $page = MemberProfilePage::get()->filter('GroupID',Group::get()->filter('Code','kunden')->first()->ID)->first();
        //$admin = singleton(DefaultAdminService::class)->findOrCreateDefaultAdmin();
      
        $siteconfig = SiteConfig::current_site_config();
        $emailAdmin = $siteconfig->Email;
        $config = $this->getConfig();
        $body = $config->CustomerOfferEmailBody;

        $email = new MissionEmail($config,$this,$siteconfig->Email,$this->Email,"Unser Angebot für Ihre Auftrag",  $body);
        $email->setBCC($siteconfig->Email);

        //Angebot
        //$email->addAttachment(dirname(__FILE__).'/../../..'.$this->OfferFile()->getURL(),'Angebot.pdf');
        //$email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBCustomerFile()->getURL(),'AGB.pdf');

        $email->send();

        $this->SentDate = date('Y-m-d');
        $this->write();
    }

    public function sendAdminMail(){
        $page = MemberProfilePage::get()->filter('GroupID',Group::get()->filter('Code','kunden')->first()->ID)->first();
        // $admin = singleton(DefaultAdminService::class)->findOrCreateDefaultAdmin();
        // $emailAdmin = $admin->Email;
        $config = SiteConfig::current_site_config();
        $emailAdmin = $config->Email;
        
        $body = "<p>Eine neue Aufträge braucht Ihre Prüfung</p>";
        $body .= '<p><strong>Kunde :</strong><br>'.$this->CustomerTitle().'</p>';
        $body .= '<p><strong>Auftrag :</strong><br>'.$this->Title.'</p>';
        $body .= '<p><a href="'.Director::absoluteBaseUrl().'admin/'.Config::inst()->get('UserAdmin','url_segment').'/Mission">'._t('Mission.CheckMission','Kunde / Auftrag prüfen').'</a></p>';
        $email = new MemberEmail($page,$this->Customer()->Member(),$config->Email, $emailAdmin,"Eine neue Auftrag braucht Ihre Prüfung",  $body);
        
        $email->send();
    }

    public function sendEmailToCandidats(){

        $siteconfig = SiteConfig::current_site_config();
        $config = $this->getConfig();
        $body = $config->CandidatOffersEmailBody;

        $email = new MissionEmail($config,$this,$siteconfig->Email,null,"Neue Auftrag verfügbar",  $body);
        
        foreach(Candidat::get()->filter('Status','approved') as $Candidat){
           $email->setTo($Candidat->Member()->Email);
           $email->send();
        }
       
    }

     public function sendEmailToApprovedCandidat($Candidat){
        $siteconfig = SiteConfig::current_site_config();
        $emailAdmin = $siteconfig->Email;
        $config = $this->getConfig();
        $body = $config->ChosenCandidatEmailBody;

        $email = new MissionEmail($config,$this,$siteconfig->Email,$Candidat->Member()->Email,"Ihre Bewerbung wurde genehmigt",  $body);
        $email->setBCC($siteconfig->Email);
        

        //Auftrag
        $email->addAttachment(dirname(__FILE__).'/../../..'.$this->ContractFile()->getURL(),'Auftrag.pdf');
        $email->addAttachment(dirname(__FILE__).'/../../..'.$config->AGBCandidatFile()->getURL(),'AGB.pdf');
        $email->send();
        $this->Status = "contractSent";
        $this->SentContractDate = date('Y-m-d');
        $this->write();
       
    }

     public function notifyAdminEmail(){
        $page = MemberProfilePage::get()->filter('GroupID',Group::get()->filter('Code','kunden')->first()->ID)->first();
        $config = SiteConfig::current_site_config();
        $emailAdmin = $config->Email;
        
        $body = "<p>Eine neue Bewerbung wurde gesendet.</p>";
        // $body .= '<p><strong>Koch :</strong><br>'.$this->Candidat()->FirstName.' '.$this->Candidat()->Surname.'</p>';
        $body .= '<p><strong>Kunde :</strong><br>'.$this->Customer()->Member()->getTitle().'</p>';
        $body .= '<p><strong>Auftrag :</strong><br>'.$this->Title.'</p>';
        $body .= '<p><a href="'.Director::absoluteBaseUrl().'admin/'.Config::inst()->get('UserAdmin','url_segment').'/Mission">'._t('Mission.CheckCandidature','Bewerbung prüfen').'</a></p>';
        $email = new MemberEmail($page,$this->Customer()->Member(),$config->Email, $emailAdmin,"Eine neue Bewerbung wurde gesendet",  $body);
        
        $email->send();
    }

    public function sendEndConfirmationEmails(){
        $siteconfig = SiteConfig::current_site_config();
        $emailAdmin = $siteconfig->Email;
        $config = $this->getConfig();
        $body = $config->CustomerContractSignedEmailBody;

        $email = new MissionEmail($config,$this,$siteconfig->Email,$this->Customer()->Member()->Email,"Annahme Ihres Angebotes",  $body);

        $email->addCC($siteconfig->Email);
        $email->addCC($this->Candidat()->Member()->Email);

        $email->send();

    }


}