<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;
use SilverStripe\Security\Security;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\GroupedList;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class JobPortalConfig extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'CandidatureHelpTitle' => 'Varchar',
        'CandidatureHelpText' => 'HTMLText',
        'CandidatureSentText' =>  'HTMLText',
        'CandidatureAlreadySentText' =>  'HTMLText',
        'EmailSignature' => 'HTMLText',

        //Registration
        'EmailValidationRequired' => 'Boolean(0)',
       
        //Step 1
        'AfterRegistrationTitle'   => 'Varchar(255)',
        'AfterRegistrationContent' => 'HTMLText',
        'AfterRegistrationEmailFrom'                => 'Varchar(255)',
        'AfterRegistrationEmailSubject'             => 'Varchar(255)',
        'AfterRegistrationEmailBody'            => 'HTMLText',

        //Step 2
        'AfterConfirmationTitle'   => 'Varchar(255)',
        'AfterConfirmationContent' => 'HTMLText',
        'AfterConfirmationEmailFrom'                => 'Varchar(255)',
        'AfterConfirmationEmailTo'                => 'Varchar(255)',
        'AfterConfirmationEmailSubject'             => 'Varchar(255)',
        'AfterConfirmationEmailBody'            => 'HTMLText',

        'AlreadyConnected'         => 'HTMLText',
   

        'AccountTabHTML' => 'HTMLText',
        'ProfilTabHTML' => 'HTMLText',
        'OffersTabHTML' => 'HTMLText',
        'PaymentTabHTML' => 'HTMLText',
        'AdsTabHTML' => 'HTMLText',

        //Candidature
        'CandidatureEmailSubject'             => 'Varchar(255)',
        'CandidatureEmailBody'            => 'HTMLText',
        'AfterRefusalCandidatureEmailSubject'             => 'Varchar(255)',
        'AfterRefusalCandidatureEmailBody'            => 'HTMLText',
        
    );

    private static $singular_name = "Einstellungen";
    private static $plural_name = "Einstellungen";

    private static $has_one = [
        'OfferFile' => File::class,
        'File' =>  File::class,
    ];

    private static $has_many = [
        'Parameters' => JobParameter::class,
        'ProfilParameters' => ProfilParameter::class,
        'QueryParameters' => ProfilParameter::class
    ];

    private static $owns = [
        'OfferFile', 'File'
    ];

    private static $summary_fields = [
        'Title' => ['title' => 'Titel']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Titel');
   
    $labels['OfferFile'] = _t(__CLASS__.'.OfferFile','Bewerbung Vorlage');
    $labels['File'] = _t(__CLASS__.'.File','Stellenangebot Vorlage');
    $labels['CandidatureSentText'] = _t(__CLASS__.'.CandidatureSentText','Bewerbung gesendet');
    $labels['CandidatureAlreadySentText'] = _t(__CLASS__.'.CandidatureAlreadySentText','Bewerbung bereits gesendet');
    $labels['CandidatureHelpTitle'] = _t(__CLASS__.'.CandidatureHelpTitle','Titel der Bewerbung Pop-up Fenster');
    $labels['CandidatureHelpText'] = _t(__CLASS__.'.CandidatureHelpText','Inhalt der Bewerbung Pop-up Fenster');
    $labels['EmailSignature'] = _t(__CLASS__.'.EmailSignature','E-Mail Signatur');
    $labels['AfterRefusalCandidatureEmailBody'] = _t(__CLASS__.'.AfterRefusalCandidatureEmailBody','Inhalt der Email - Bewerbung abgelehnt');
    $labels['AfterRefusalCandidatureEmailSubject'] = _t(__CLASS__.'.AfterRefusalCandidatureEmailSubject','Titel der Email - Bewerbung abgelehnt');
    $labels['CandidatureEmailSubject'] = _t(__CLASS__.'.CandidatureEmailSubject','Titel der Email - Bewerbung');
    $labels['CandidatureEmailBody'] = _t(__CLASS__.'.CandidatureEmailBody','Inhalt der Email - Bewerbung');
    $labels['QueryParameters'] = _t(__CLASS__.'.QueryParameters','Matching Tool Parameter (Prio 1)');
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
        $fields->removeByName('GroupID');
        $fields->removeByName('EmailValidationRequired');
        $fields->removeByName('AfterRegistrationContent');
        $fields->removeByName('AfterRegistrationTitle');
        $fields->removeByName('AfterRegistrationEmailFrom');
        $fields->removeByName('AfterRegistrationEmailSubject');
        $fields->removeByName('AfterRegistrationEmailBody');
        $fields->removeByName('AfterConfirmationTitle');
        $fields->removeByName('AfterConfirmationContent');
        $fields->removeByName('AfterConfirmationEmailFrom');
        $fields->removeByName('AfterConfirmationEmailSubject');
        $fields->removeByName('AfterConfirmationEmailBody');
        $fields->removeByName('AccountTabHTML');
        $fields->removeByName('ProfilTabHTML');
        $fields->removeByName('OffersTabHTML');
        $fields->removeByName('AdsTabHTML');
        $fields->removeByName('PaymentTabHTML');
        $fields->removeByName('Parameters');
        $fields->removeByName('ProfilParameters');


            $fields->addFieldsToTab('Root.Registration',[
                   CheckboxField::create('EmailValidationRequired',_t(__CLASS__.'.EmailValidationRequired','Email Prüfung erfordert?')),
                   HeaderField::create('InscriptionTitle',_t(__CLASS__.".BackInscriptionTitle","Inscription - Step 1"),3),
                   CompositeField::create([    
                       TextField::create('AfterRegistrationTitle',_t(__CLASS__.".AfterRegistrationTitle", 'Page title (after first step registration)')),
                       HTMLEditorField::create('AfterRegistrationContent',_t(__CLASS__.".AfterRegistrationContent", 'Page content (after first step registration)')),
                       TextField::create('AfterRegistrationEmailFrom',_t(__CLASS__.".AfterRegistrationEmailFrom", 'Validation Email sender')),
                       TextField::create('AfterRegistrationEmailSubject',_t(__CLASS__.".AfterRegistrationEmailSubject", 'Validation email subject')),
                       HTMLEditorField::create('AfterRegistrationEmailBody',_t(__CLASS__.".AfterRegistrationContent", 'Validaiton email body')),
                   ]),
                    HeaderField::create('InscriptionTitle2',_t(__CLASS__.".BackInscriptionTitle2","Inscription - Step 2"),3)->displayIf('EmailValidationRequired')->isChecked()->end(),
                    CompositeField::create([ 
                        
                        Wrapper::create(
                            CompositeField::create([ 
                                TextField::create('AfterConfirmationTitle',_t(__CLASS__.".AfterConfirmationTitle", 'Page title (after email validation)')),
                                HTMLEditorField::create('AfterConfirmationContent',_t(__CLASS__.".AfterConfirmationContent", 'Page content (after email validation)')),
                                TextField::create('AfterConfirmationEmailFrom',_t(__CLASS__.".AfterConfirmationEmailFrom", 'Confirmation email sender')),
                                TextField::create('AfterConfirmationEmailSubject',_t(__CLASS__.".AfterConfirmationEmailSubject", 'Confirmation email subject')),
                                HTMLEditorField::create('AfterConfirmationEmailBody',_t(__CLASS__.".AfterConfirmationContent", 'Confirmation email body')),
                            ])
                        )->displayIf('EmailValidationRequired')->isChecked()->end()
                    ]),
                
                
                   HTMLEditorField::create('AlreadyConnected',_t(__CLASS__.".AlreadyConnected", 'Content to show for connected User')),
                   
                ]
            );

        $fields->FieldByName('Root.Registration')->setTitle('Registrierung');

        $fields->addFieldToTab('Root.Profile', CompositeField::create(
            HTMLEditorField::create('AccountTabHTML',_t(__CLASS__.'.AccountTabHTML','Text für den Bereich "Adressangaben"'))->setRows(3),
            HTMLEditorField::create('ProfilTabHTML',_t(__CLASS__.'.ProfilTabHTML','Text für den Bereich "Firmenporträt"'))->setRows(3),
            HTMLEditorField::create('OffersTabHTML',_t(__CLASS__.'.OffersTabHTML','Text für den Bereich "Inserate"'))->setRows(3),
            HTMLEditorField::create('PaymentTabHTML',_t(__CLASS__.'.PaymentTabHTML','Text für den Bereich "Pakete"'))->setRows(3),
            HTMLEditorField::create('AdsTabHTML',_t(__CLASS__.'.AdsTabHTML','Text für den Bereich "Bewerbungen"'))->setRows(3)
        ));
       

    
       $fields->addFieldToTab('Root.Main',UploadField::create('OfferFile',$this->fieldLabels()['OfferFile'])->setFolderName('Uploads/Vorlagen'));
       $fields->addFieldToTab('Root.Main',UploadField::create('File',$this->fieldLabels()['File'])->setFolderName('Uploads/Vorlagen'));
        
       $config = GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'));
       $fields->addFieldToTab('Root.Parameters',GridField::create('Parameters','Job Parameters',$this->Parameters()->filter('ClassName',JobParameter::class),$config));
       $fields->FieldByName('Root.Parameters')->setTitle('Job Parameters');

       $config2 = GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'));
       $fields->addFieldToTab('Root.Profile',GridField::create('ProfilParameters','Profil Parameters',$this->ProfilParameters(),$config2));

       $fields->addFieldToTab('Root.MatchingTool',ListboxField::create('QueryParameters','MatchingTool Parameter (Prio 1)',$this->QueryParameters(), ProfilParameter::get()->map('ID','Title')));

       return $fields;
    }

    public function parseString($string)
    {
        $member = Security::getCurrentUser();
        $absoluteBaseURL = Director::absoluteBaseURL();

       $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$LoginLink'      => Controller::join_links(
                $absoluteBaseURL,
                singleton(Security::class)->Link('login')
            ),
            '$AccountLink' => $member->MemberPageLink()
        );
        foreach (array('Name', 'FirstName', 'Surname', 'Email') as $field) {
            $variables["\$Member.$field"] = $member->$field;
        }
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }

    public function activePlaces(){
        $activeOffers = Mission::get()->filter('isActive',1);
        if ($activeOffers->exists()){
            $places = $activeOffers->column('City');
        }
        return array_unique($places);
    }

    public function activeCountries(){
        $activeOffers = Mission::get()->filter('isActive',1)->sort('Country','ASC');
        return GroupedList::create($activeOffers);
    }

    public function activeCities($countryTitle){
        $country = array_search($countryTitle,i18n::getData()->getCountries());
        $activeOffers = Mission::get()->filter(['isActive' => 1, 'Country' => $country])->sort('City','ASC');
        return GroupedList::create($activeOffers);
    }
    
    public function activeDates(){
        $activeOffers = Mission::get()->filter('isActive',1)->sort('PublishedDate','DESC');
        return GroupedList::create($activeOffers);
    }

    public function getPositions(){
        $param = $this->Parameters()->filter('Title','Position')->first();
        if ($param){
            return $param->Values()->sort('Title');
        }
        return null;
    }

    public function getCities(){
        return GroupedList::create(Mission::get()->filter('isActive',1)->sort('City'));
    }


}