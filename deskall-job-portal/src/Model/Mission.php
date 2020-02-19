<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
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
use SilverStripe\Forms\ListboxField;
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
use Bummzack\SortableFile\Forms\SortableUploadField;

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
        'isClosed' => 'Boolean(0)',
        'PublishedDate' => 'Date',
        'Nummer' => 'Varchar'
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
        'ContractFile' => File::class,
        'Image' => Image::class
    ];

    private static $owns = ['OfferFile','ContractFile','Candidatures','Parameters','Image'];

    private static $has_many = [
        'Candidatures' => Candidature::class,
        'Parameters' => AssignedJobParameter::class
    ];

    private static $many_many = [
        'Attachments' => File::class
    ];

    private static $many_many_extraFields = [
        'Attachments' => ['SortOrder' => 'Int']
    ];


    private static $summary_fields = [
        'Nummer' => ['title' => 'Nr.'],
        'NiceStatus' => ['title' => 'Status'],
        'Title',
        'Customer.NiceAddress' => ['title' => 'Kunde']
    ];

    private static $searchable_fields = [
        'Title',
        'Customer.Title'
    ];


    private static $cascade_deletes = ['OfferFile','ContractFile','Candidatures','Parameters','Image'];



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
    $labels['Image'] = _t(__CLASS__.'.Image','Bild');
    $labels['Attachments'] = _t(__CLASS__.'.Attachments','Anhängen');

    return $labels;
    }

    

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if ($this->Customer()->exists() && !$this->Company){
          $this->Company = $this->Customer()->Company;
        }
        if ($this->Customer()->exists() && !$this->Nummer){
          $this->Nummer = $this->Customer()->Nummer.'-'.str_pad($this->ID, 4, '0', STR_PAD_LEFT);
        }
        $this->createOffer();
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

    }

    public function onBeforeDelete(){
        parent::onBeforeDelete();
        if ($this->OfferFile()->exists()){
            $this->OfferFile()->File->deleteFile();
            DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($this->OfferFile()->ID));
            $this->OfferFile()->delete();
        }
        //delete folder
        $folder = Folder::find_or_make($this->getFolderName());
        $folder->File->deleteFile();
        DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($folder->ID));
        $folder->delete();
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

    public function getFolderName(){
        return 'Uploads/Stellenangebot/'.str_replace('.','-',$this->Nummer);
    }

    public function ShortDescription(){
      $html = '<p>';
      $html .= '#'.$this->Nummer.'<br>';
      $html .= '<a href="'.$this->previewLink().'" title="'._t('Mission.See','Stelleangebot ansehen').'" target="_blank" data-uk-tooltip><strong class="uk-text-truncate">'.$this->Title.'.</strong></a><br>';
      $html .= $this->City;
      $html .= '</p>';
      return DBHTMLText::create()->setValue($html);
    }

    public function getFormFields(){
        $customer = JobGiver::get()->filter('MemberID',Security::getCurrentUser()->ID)->first();
        $fields = FieldList::create(
            HiddenField::create('CustomerID')->setValue($customer->ID),
            TextField::create('Title',$this->fieldLabels()['Title'])->setAttribute('class','uk-input'),
            $parameters = CompositeField::create()->setName('ParametersFields'),
            TextField::create('City',$this->fieldLabels()['City']),
            DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('de'),
            // DateField::create('Start',$this->fieldLabels()['Start'])->setAttribute('class','uk-input'),
            // DateField::create('End',$this->fieldLabels()['End'])->setAttribute('class','uk-input'),
            HTMLEditorField::create('Description',$this->fieldLabels()['Description']),
            SortableUploadField::create('Attachments',$this->fieldLabels()['Attachments']),
            HiddenField::create('ImageID')
        );

        $config = $this->getJobConfig();
        foreach ($config->Parameters() as $p) {
            switch ($p->FieldType){
                case "text":
                    $field = TextField::create($p->Title,$p->Title)->setAttribute('class','uk-input');
                    break;
                case "dropdown":
                    $field = DropdownField::create($p->Title,$p->Title,$p->Values()->map('ID','Title'))->setAttribute('class','uk-select');
                    break;
                case "multiple":
                    $field = CheckboxSetField::create($p->Title,$p->Title,$p->Values()->map('ID','Title'))->setAttribute('class','uk-checkbox');
                    break;
                case "multiple-free":
                    $field = ListboxField::create($p->Title,$p->Title,$p->Values()->map('ID','Title'))->setAttribute('class','uk-input');
                    break;
            }
           if ($this->Parameters()->filter('Title',$p->Title)->first()){
               $field->setValue($p->Values()->filter('Title',$this->Parameters()->filter('Title',$p->Title)->first()->Value)->first()->ID);
           }
           $parameters->push($field);
        }

        return $fields;
    }

    public function getRequiredFields(){
        $fields = ['Title','Description','City','Country'];
        $config = $this->getJobConfig();
        foreach ($config->Parameters() as $p) {
            if ($p->Required){
                $fields[] = $p->Title;
            }
        }

        return new RequiredFields($fields);
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

    public function editLink(){
        return ($this->Customer()->Member()->MemberPage->exists()) ? $this->getJobsPage()->Link().'inserate-bearbeiten/'.$this->ID : null;
    }

    public function getJobsPage(){
        return OfferPage::get()->first();
    }

    public function getJobConfig(){
        return JobPortalConfig::get()->first();
    }


     public function canEdit($member = null){
        if ($this->isClosed || $this->isActive){
             return Permission::check('ADMIN');
        }
        else{
            $member = Security::getCurrentUser();
            if ($this->Customer()->MemberID == $member->ID){
                return true;
            }
            return parent::canEdit($member);
        }
    }

    public function canDelete($member = null){
        if ($this->isActive){
            return Permission::check('ADMIN');
        }
        else{
            $member = Security::getCurrentUser();
            if ($this->Customer()->MemberID == $member->ID){
                return true;
            }
            return parent::canDelete($member);
        }
    }

    public function canPublish($member = null){
        if ($this->isClosed || $this->isActive){
            return false;
        }
        else if (!$this->Customer()->activeOrder()){
          return false;
        }
        else{
            $member = Security::getCurrentUser();
            if ($this->Customer()->MemberID == $member->ID){
                return true;
            }
            return parent::canEdit($member);
        }
    }

    public function canUnpublish($member = null){
          if ($this->isClosed || !$this->isActive){
            return false;
          }
            $member = Security::getCurrentUser();
            if ($this->Customer()->MemberID == $member->ID){
                return true;
            }
            return parent::canEdit($member);
        
    }

    public function publish(){
        if ($this->canPublish()){
            $this->isActive = true;
            $this->PublishedDate = date('d.m.Y H:i');
            $this->write();
            //update order
            $order = $this->Customer()->activeOrder();
            if ($order){
              $order->RemainingOffers = $order->RemainingOffers - 1;
              //Start validity if first mission
              if (!$order->StartValidity){
                $order->StartValidityPeriod();
              }
              $order->write();
            }
            
        }
    }

    public function unpublish(){
        if ($this->canUnpublish()){
            $this->isActive = false;
            $this->write();
            //update order
            $order = $this->Customer()->activeOrder();
            if ($order){
              $order->RemainingOffers = $order->RemainingOffers + 1;
              $order->write();
            }
            
        }
    }

    public function NiceStatus(){
        if ($this->isClosed){
            return _t('Mission.Archived','Archiviert');
        }
        if ($this->isActive){
            return _t('Mission.Active','Erste Veröffentlichung: {date}', ['date' => $this->PublishedDate]);
        }
        return _t('Mission.Draft','Entwurf');
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

    public function getCountryTitle(){
      return i18n::getData()->getCountries()[$this->Country];
    }

    public function getCityTitle(){
      return ucfirst($this->City);
    }

    public function getPublishedPeriod(){
      $date = new \DateTime($this->PublishedDate);
      $now = new \DateTime();
      $diff = $now->diff($date)->format("%a");
      if ($diff < 3){
        return _t('Mission.PublishedPeriod1','< 3 Tage');
      }
      if ($diff >= 3 && $diff < 7){
        return _t('Mission.PublishedPeriod2','3 - 7 Tage');
      }
      if ($diff >= 7 && $diff < 14){
        return _t('Mission.PublishedPeriod3','7 - 14 Tage');
      }
      return _t('Mission.PublishedPeriod4','> 14 Tage');
    }

    public function canCandidate(){
        $member = Security::getCurrentUser();
        if ($member){
            $Candidat = Candidat::get()->filter('MemberID',$member->ID)->first();
            if ($Candidat){
              if (!Candidature::get()->filter(['CandidatID' => $Candidat->ID, 'MissionID' => $this->ID])->first()){
                    return true;
                }  
            }
        }
        return false;
    }

    public function hasCandidated(){
      $member = Security::getCurrentUser();
      if ($member && $member->inGroup('kandidaten')){
          $Candidat = Candidat::get()->filter('MemberID',$member->ID)->first();
          if ($Candidat){
            if ($c = Candidature::get()->filter(['CandidatID' => $Candidat->ID, 'MissionID' => $this->ID])->first()){
                  return $c;
              }  
          }
      }
      return false;
    }

    public function canSendEmail(){
        return (Permission::check('ADMIN') && $this->isVisible);
    }

    public function canClose(){
        return true;
    }
    

    public function createOffer(){
      $config = $this->getConfig();

      $pdf = new Fpdi();
      $src = dirname(__FILE__).'/../../..'.$config->File()->getURL();
      $output = dirname(__FILE__).'/../../../assets/Uploads/tmp/angebot_'.$this->Nummer.'.pdf';

      $pdf->Addfont('Lato','','lato.php');
      $pageCount = $pdf->setSourceFile($src);
      for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $templateId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($templateId);
            $pdf->useTemplate($templateId);
            $pdf->SetFont('Lato','',8);
            $pdf->setXY(8,8);
            $pdf->WriteHTML($this->renderWith('Includes/MissionData'));
      }
      $pdf->Output($output,'F');
      


      $tmpFolder = $this->getFolderName();
      $folder = Folder::find_or_make($tmpFolder);
      $file = ($this->OfferFile()->exists() ) ? $this->OfferFile() : File::create();
      $file->ParentID = $folder->ID;
      $file->setFromLocalFile($output, $this->getFolderName().'/Angebot.pdf');
      $file->write();
      $file->publishSingle();
      $this->OfferFileID = $file->ID;      
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

     public function notifyAdminEmail(){
        $page = MemberProfilePage::get()->first();
        $config = SiteConfig::current_site_config();
        $emailAdmin = $config->Email;
        
        $body = "<p>Eine neue Bewerbung wurde gesendet.</p>";
        // $body .= '<p><strong>Koch :</strong><br>'.$this->Candidat()->FirstName.' '.$this->Candidat()->Surname.'</p>';
        $body .= '<p><strong>Kunde :</strong><br>'.$this->Customer()->Member()->getTitle().'</p>';
        $body .= '<p><strong>Stellenangebot :</strong><br>'.$this->Title.'</p>';
        $body .= '<p><a href="'.Director::absoluteBaseUrl().'admin/'.Config::inst()->get('UserAdmin','url_segment').'/Mission">'._t('Mission.CheckCandidature','Bewerbung prüfen').'</a></p>';
        $email = new MemberEmail($page,$this->Customer()->Member(),$config->Email, $emailAdmin,"Eine neue Bewerbung wurde gesendet",  $body);
        
        $email->send();
    }


}