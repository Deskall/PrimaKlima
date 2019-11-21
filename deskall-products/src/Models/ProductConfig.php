<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Controller;

class ProductConfig extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'CustomerAccountLabel' => 'HTMLText',
        'BillPayLabel' => 'HTMLText',
        'OnlinePayLabel' => 'HTMLText',
        'PaymentConfirmedLabel' => 'HTMLText',
        'EmailCustomerAccountDataBody' => 'HTMLText',
        'BillEmailSubject' => 'Varchar',
        'BillEmailBody' => 'HTMLText',
        'PaymentEmailSubject' => 'Varchar',
        'PaymentEmailBody' =>  'HTMLText',
        'OrderNumberOffset' => 'Int',
        'BuySuccessfullMessage' => 'HTMLText',
        'TransportCost' => 'Currency',
        'TransportLabel' => 'HTMLText',
        'CertificatHTML' => 'HTMLText'
       
    );

    private static $singular_name = "Einstellungen";
    private static $plural_name = "Einstellungen";

    private static $has_one = [
       'CertificatFile' => File::class,
       'BillFile' => File::class,
       'AGBFile' => File::class,
       'ReceiptFile' => File::class
    ];

    private static $owns = [
        'CertificatFile',
        'BillFile',
        'AGBFile',
        'ReceiptFile'
    ];

    private static $summary_fields = [
        'Title' => ['title' => 'Titel']
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Titel');
    $labels['CustomerAccountLabel'] = _t(__CLASS__.'.CustomerAccountLabel','Text für das Kundenkonto Label');
    $labels['TransportCost'] = _t(__CLASS__.'.TransportCost','TransportKosten (pauschalpreis)');
    $labels['CertificatFile'] = _t(__CLASS__.'.CertificatFile','Zertifikat Vorlage');
    $labels['CertificatHTML'] = _t(__CLASS__.'.CertificatHTML','Inhalt für Zertifikat');
    $labels['BillFile'] = _t(__CLASS__.'.BillFile','Rechnung Vorlage');
    $labels['BillPayLabel'] = _t(__CLASS__.'.BillPayLabel','Text für die Zahlung mit Rechnung');
    $labels['OnlinePayLabel'] = _t(__CLASS__.'.OnlinePayLabel','Text für die Zahlung mit PayPal oder Kreditkarte');
    $labels['PaymentConfirmedLabel'] = _t(__CLASS__.'.PaymentConfirmedLabel','Zahlungsbestätigungstext');
    $labels['BillEmailSubject'] = _t(__CLASS__.'.BillEmailSubject','Rechnungsemail Betreff');
    $labels['BillEmailBody'] = _t(__CLASS__.'.BillEmailBody','Rechnungsemail Inhalt');
    $labels['PaymentEmailSubject'] = _t(__CLASS__.'.PaymentEmailSubject','Zahlunsbestätigungsemail Betreff');
    $labels['PaymentEmailBody'] = _t(__CLASS__.'.PaymentEmailBody','Zahlunsbestätigungsemail Inhalt');
    $labels['AGBFile'] = _t(__CLASS__.'.AGBFile','AGB Datei');
    $labels['ReceiptFile'] = _t(__CLASS__.'.ReceiptFile','Quittung Vorlage');
   
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

       $fields->addFieldToTab('Root.Main',UploadField::create('CertificatFile',$this->fieldLabels()['CertificatFile'])->setFolderName('Uploads/Vorlagen'));
        $fields->addFieldToTab('Root.Main',UploadField::create('BillFile',$this->fieldLabels()['BillFile'])->setFolderName('Uploads/Vorlagen'));
        $fields->addFieldToTab('Root.Main',UploadField::create('ReceiptFile',$this->fieldLabels()['ReceiptFile'])->setFolderName('Uploads/Vorlagen'));
       $fields->addFieldToTab('Root.Main',UploadField::create('AGBFile',$this->fieldLabels()['AGBFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Vorlagen'));
      
      

       return $fields;
    }


    public function parseString($string,$order)
    {


        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$Datum'          => date('d.m.Y')
            // '$LoginLink'      => Controller::join_links(
            //     $absoluteBaseURL,
            //     singleton(Security::class)->Link('login')
            // ),
           
        );
        if ($order){
           foreach (array('Name', 'Vorname', 'Email','Gender','Price') as $field) {
              $variables["\$Order.$field"] = $order->$field;
           }
        }

        if ($order->Product()){
           foreach (array('Title', 'CertificatTitle', 'CertificatLabel','CertificatDescription','CertificatNotice') as $field) {
              $variables["\$Product.$field"] = $order->Product()->$field;
           }

           foreach (array('currentPrice') as $method) {
              $variables["\$Product.$method"] = $order->Product()->{$method}();
           }
        }

        if ($order->Customer()){
           foreach (array('Gender', 'Birthday','BirthPlace','Address','City','PostalCode') as $field) {
              $variables["\$Customer.$field"] = $order->Customer()->$field;
           }
           foreach (array('FirstName', 'Surname') as $field) {
              $variables["\$Customer.$field"] = $order->Customer()->Member()->$field;
           }

           foreach (array('printAddress','printTitle') as $method) {
              $variables["\$Customer.$method"] = $order->Customer()->{$method}();
           }
        }
        
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }
  


}