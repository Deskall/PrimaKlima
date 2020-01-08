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

class JobPortalConfig extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'AutoOffer' => 'Boolean(0)',
        'Usage' => 'Varchar',
        'TransportCost' => 'Varchar',
        'CostAndHousing' => 'Varchar',
        'AgentCost' => 'Varchar',
        'OfferValidityText' => 'Varchar',
        'OfferValidity' => 'Decimal',
        'ContractValidityText' => 'Varchar',
        'ContractValidity' => 'Decimal', 
        'Intro' => 'HTMLText',
        'Diverse' => 'HTMLText',
        'Conditions' => 'HTMLText',
        'IntroContract' => 'HTMLText',
        'DiverseContract' => 'HTMLText',
        'ConditionsContract' => 'HTMLText',
        'CustomerOfferEmailBody' => 'HTMLText',
        'OfferConfirmedText' => 'HTMLText',
        'OfferAlreadyConfirmedText' => 'HTMLText',
        'CookOffersEmailBody' =>  'HTMLText',
        'CandidatureHelpTitle' => 'Varchar',
        'CandidatureHelpText' => 'HTMLText',
        'CandidatureSentText' =>  'HTMLText',
        'CandidatureAlreadySentText' =>  'HTMLText',
        'ReminderOfferEmailSubject' => 'Varchar',
        'ReminderOfferEmailBody' => 'HTMLText',
        'ChosenCookEmailBody' => 'HTMLText',
        'CookContractSignedText' => 'HTMLText',
        'CustomerContractSignedEmailBody' =>  'HTMLText',
        'EmailSignature' => 'HTMLText'
        
    );

    private static $singular_name = "Einstellungen";
    private static $plural_name = "Einstellungen";

    private static $has_one = [
        'OfferFile' => File::class ,
        'ContractFile' => File::class,
        'AGBCustomerFile' => File::class,
        'AGBCookFile' => File::class,
    ];

    private static $has_many = [
        'Parameters' => JobParameter::class
    ];

    private static $owns = [
        'OfferFile',
        'ContractFile',
        'AGBCookFile',
        'AGBCustomerFile'
    ];

    private static $summary_fields = [
        'Title' => ['title' => 'Titel']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Titel');
    $labels['Usage'] = _t(__CLASS__.'.Usage','Einsatz');
    $labels['OfferValidityText'] = _t(__CLASS__.'.Title','Gültigkeit des Angebots (Text)');
    $labels['OfferValidity'] = _t(__CLASS__.'.Usage','Gültigkeit des Angebots (Tag)');
    $labels['ContractValidityText'] = _t(__CLASS__.'.Title','Gültigkeit des Vertrages (Text)');
    $labels['ContractValidity'] = _t(__CLASS__.'.Usage','Gültigkeit des Vertrages (Tag)');
    $labels['TransportCost'] = _t(__CLASS__.'.TransportCost','Fahrtkosten');
    $labels['CostAndHousing'] = _t(__CLASS__.'.CostAndHousing','Kost&Logis');
    $labels['AgentCost'] = _t(__CLASS__.'.AgentCost','Agentur-Gebühr');
    $labels['OfferFile'] = _t(__CLASS__.'.OfferFile','Angebot Vorlage');
    $labels['Intro'] = _t(__CLASS__.'.Intro','Angebot Einstiegtext');
    $labels['Diverse'] = _t(__CLASS__.'.Diverse','Angebot Details');
    $labels['Conditions'] = _t(__CLASS__.'.Conditions','Angebot Konditionen');
    $labels['IntroContract'] = _t(__CLASS__.'.IntroContract','Vertrag Einstiegtext');
    $labels['DiverseContract'] = _t(__CLASS__.'.DiverseContract','Vertrag Details');
    $labels['ConditionsContract'] = _t(__CLASS__.'.ConditionsContract','Vertrag Konditionen');
    $labels['CustomerOfferEmailBody'] = _t(__CLASS__.'.CustomerOfferEmailBody','Kunde Angebot : Inhalt der E-Mail');
    $labels['OfferConfirmedText'] = _t(__CLASS__.'.OfferConfirmedText','Text für den Angebot-bestätigung Text');
    $labels['OfferAlreadyConfirmedText'] = _t(__CLASS__.'.OfferAlreadyConfirmedText','Angebot bereits bestätigt');
    $labels['CookOffersEmailBody'] = _t(__CLASS__.'.CookOffersEmailBody','Neue Angebot: Inhalt der Email für alle Köche');
    $labels['CandidatureSentText'] = _t(__CLASS__.'.CandidatureSentText','Bewerbung gesendet');
    $labels['CandidatureAlreadySentText'] = _t(__CLASS__.'.CandidatureAlreadySentText','Bewerbung bereits gesendet');
    $labels['CustomerContractSignedEmailBody'] = _t(__CLASS__.'.CustomerContractSignedEmailBody','Kunde Vertrag Bestätigung : Inhalt der Email');
    $labels['ReminderOfferEmailSubject'] = _t(__CLASS__.'.ReminderOfferEmailSubject','Betreff der Angebot-Erinnerungsemail');
    $labels['ReminderOfferEmailBody'] = _t(__CLASS__.'.ReminderOfferEmailBody','Inhalt der Angebot-Erinnerungsemail');
    $labels['ContractFile'] = _t(__CLASS__.'.ContractFile','Auftrag Vorlage');
    $labels['ChosenCookEmailBody'] = _t(__CLASS__.'.ChosenCookEmailBody','Inhalt der Email für den gewählt Koch (mit Auftrag)');
    $labels['CandidatureHelpTitle'] = _t(__CLASS__.'.CandidatureHelpTitle','Titel der Bewerbung Pop-up Fenster');
    $labels['CandidatureHelpText'] = _t(__CLASS__.'.CandidatureHelpText','Inhalt der Bewerbung Pop-up Fenster');
    $labels['CookContractSignedText'] = _t(__CLASS__.'.CookContractSignedText','Text nach Auftrag Genehmigung durch Koch');
    $labels['AGBCustomerFile'] = _t(__CLASS__.'.AGBCustomerFile','AGB Datei (Kunde)');
    $labels['AGBCookFile'] = _t(__CLASS__.'.AGBCookFile','AGB Datei (Koch)');
    $labels['EmailSignature'] = _t(__CLASS__.'.EmailSignature','E-Mail Signatur');
    $labels['AutoOffer'] = _t(__CLASS__.'.AutoOffer','E-Mail mit Angebot an Kunde nach Anfrage senden?');

    
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

       $fields->addFieldToTab('Root.Main',UploadField::create('OfferFile',$this->fieldLabels()['OfferFile'])->setFolderName('Uploads/Vorlagen'));
       $fields->addFieldToTab('Root.Main',UploadField::create('ContractFile',$this->fieldLabels()['ContractFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Vorlagen'));
       $fields->addFieldToTab('Root.Main',UploadField::create('AGBCustomerFile',$this->fieldLabels()['AGBCustomerFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Vorlagen'));
       $fields->addFieldToTab('Root.Main',UploadField::create('AGBCookFile',$this->fieldLabels()['AGBCookFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Vorlagen'));

       $fields->dataFieldByName('Parameters')->getConfig()->addComponent(new GridFieldOrderableRows('Sort'));

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
    


}