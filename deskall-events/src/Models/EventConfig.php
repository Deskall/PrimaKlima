<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;

class EventConfig extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'BillPayLabel' => 'HTMLText',
        'OnlinePayLabel' => 'HTMLText',
        'PaymentConfirmedLabel' => 'HTMLText',
        'BillEmailSubject' => 'Varchar',
        'BillEmailBody' => 'HTMLText',
        'PaymentEmailSubject' => 'Varchar',
        'PaymentEmailBody' =>  'HTMLText',
        'OrderNumberOffset' => 'Int'
    );

    private static $singular_name = "Einstellungen";
    private static $plural_name = "Einstellungen";

    private static $has_one = [
       'BillFile' => File::class,
       'AGBFile' => File::class,
       'ReceiptFile' => File::class
    ];

    private static $owns = [
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

       $fields->addFieldToTab('Root.Main',UploadField::create('BillFile',$this->fieldLabels()['BillFile'])->setFolderName('Uploads/Vorlagen'));
        $fields->addFieldToTab('Root.Main',UploadField::create('ReceiptFile',$this->fieldLabels()['ReceiptFile'])->setFolderName('Uploads/Vorlagen'));
       $fields->addFieldToTab('Root.Main',UploadField::create('AGBFile',$this->fieldLabels()['AGBFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Vorlagen'));
      

       return $fields;
    }

    public function parseString($string)
    {
        $variables = array(
            '$CookAccountLink' => MemberProfilePage::get()->filter('GroupID',Group::get()->filter('Code','mietkoeche')->first()->ID)->first()->Link()
        );
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }
    


}