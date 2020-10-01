<?php



use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Security\Group;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBCurrency;

class ShopConfigExtension extends DataExtension
{
    private static $db = array(
       'OrderNumberOffset' => 'Varchar',
       'OrderEmailSender' => 'Varchar',
       'OrderEmailSubject' => 'Varchar',
       'OrderEmailBody' => 'HTMLText',
       'Conditions' => 'HTMLText',
       'PLZModalTitle' => 'Varchar',
       'PLZModalBody' => 'HTMLText',
       'ConfiguratorTitle' => 'Varchar',
       'ExistingNumberLabel' => 'HTMLText',
       'MobileStepTitle' => 'Varchar',
       'MobileStepBody' => 'HTMLText',
       'WishNumberTitle' => 'Varchar',
       'WishNumberBody' => 'HTMLText',
       'Conditions' => 'HTMLText',
       'ActivationPrice' => 'Currency',
       'ActivationPriceLabel' => 'HTMLText',
       'UnknownDoseEmailSender' => 'Varchar',
       'UnknownDoseEmailSubject' => 'Varchar',
       'UnknownDoseEmailContent' => 'HTMLText',
       'PaperBillPrice' => 'Currency',
       'PaperBillLabel' => 'Text'
    );

    private static $has_one = [
      
       'AGBFile' => File::class,
       'AGBPage' => SiteTree::class,
       'MobileAGBPage' => SiteTree::class,
       
    ];

    private static $owns = [
       
        'AGBFile'
       
    ];


    public function updateFieldLabels(&$labels){
   
      $labels['AGBFile'] = _t(__CLASS__.'.AGBFile','AGB Datei');
      $labels['OrderNumberOffset'] = _t(__CLASS__.'.OrderNumberOffset','Bestellung Nummer Format');
      $labels['OrderEmailSender'] = _t(__CLASS__.'.OrderEmailBody','Bestätigungsemail Sender');
      $labels['OrderEmailSubject'] = _t(__CLASS__.'.OrderEmailBody','Bestätigungsemail Betreff');
      $labels['OrderEmailBody'] = _t(__CLASS__.'.OrderEmailBody','Bestätigungsemail Text');
      $labels['PLZModalBody'] = _t(__CLASS__.'.PLZModalBody','Text für den PLZ Verfügbarkeit Prüfung');
      $labels['PLZModalTitle'] = _t(__CLASS__.'.PLZModalTitle','Title für den PLZ Verfügbarkeit Prüfung');
      $labels['ConfiguratorTitle'] = _t(__CLASS__.'.ConfiguratorTitle','Title des Konfigurator');
      $labels['MobileStepTitle'] = _t(__CLASS__.'.MobileStepTitle','Titel des "Mobile" Schrittes');
      $labels['PLZModalTitle'] = _t(__CLASS__.'.MobileStepBody','Text des "Mobile" Schrittes');
      $labels['WishNumberTitle'] = _t(__CLASS__.'.WishNumberTitle','Titel des "Wunschnummer" Modal');
      $labels['WishNumberBody'] = _t(__CLASS__.'.WishNumberBody','Text des "Wunschnummer" Modal');
      $labels['AGBPage'] = _t(__CLASS__.'.AGBPage','AGB Seite');
      $labels['MobileAGBPage'] = _t(__CLASS__.'.MobileAGBPage','Mobile AGB Seite');
      $labels['Conditions'] = _t(__CLASS__.'.Conditions','Konditionen');
      $labels['ActivationPrice'] = _t(__CLASS__.'.ActivationPrice','Aufschaltgebühr');
      $labels['ActivationPriceLabel'] = _t(__CLASS__.'.ActivationPriceLabel','Aufschaltgebühr - Hinweis in Bestellübersicht');
      $labels['ExistingNumberLabel'] = _t(__CLASS__.'.ExistingNumberLabel','Bestehende Nummer Erklärung');
      $labels['UnknownDoseEmailSender'] = _t(__CLASS__.'.UnknownDoseEmailSender','Unbekannt Anschlussart Email Absender');
      $labels['UnknownDoseEmailSubject'] = _t(__CLASS__.'.UnknownDoseEmailSubject','Unbekannt Anschlussart Email Betreff');
      $labels['UnknownDoseEmailContent'] = _t(__CLASS__.'.UnknownDoseEmailContent','Unbekannt Anschlussart Email Inhalt');
      $labels['PaperBillPrice'] = _t(__CLASS__.'.PaperBillPrice','Papier Rechnung Kosten');
      $labels['PaperBillLabel'] = _t(__CLASS__.'.PaperBillLabel','Papier Rechnung Kosten - Hinweis in Bestellübersicht');
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }



    public function updateCMSFields(FieldList $fields)
    {
 
       $fields->addFieldToTab('Root.Shop',TextField::create('ActivationPrice',$this->owner->fieldLabels()['ActivationPrice']));
       $fields->addFieldToTab('Root.Shop',HTMLEditorField::create('ActivationPriceLabel',$this->owner->fieldLabels()['ActivationPriceLabel'])->setRows(3));
       $fields->addFieldToTab('Root.Shop',TextField::create('PaperBillPrice',$this->owner->fieldLabels()['PaperBillPrice']));
       $fields->addFieldToTab('Root.Shop',TextareaField::create('PaperBillLabel',$this->owner->fieldLabels()['PaperBillLabel'])->setRows(1));
       $fields->addFieldToTab('Root.Shop',UploadField::create('AGBFile',$this->owner->fieldLabels()['AGBFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Shop'));
       $fields->addFieldToTab('Root.Shop',UploadField::create('AGBFile',$this->owner->fieldLabels()['AGBFile'])->setIsMultiUpload(false)->setFolderName('Uploads/Shop'));
       $fields->addFieldToTab('Root.Shop',TextField::create('OrderNumberOffset',$this->owner->fieldLabels()['OrderNumberOffset']));
       $fields->addFieldToTab('Root.Shop',TextField::create('PLZModalTitle',$this->owner->fieldLabels()['PLZModalTitle']));
       $fields->addFieldToTab('Root.Shop',HTMLEditorField::create('PLZModalBody',$this->owner->fieldLabels()['PLZModalBody']));
       $fields->addFieldToTab('Root.Shop',TextField::create('ConfiguratorTitle',$this->owner->fieldLabels()['ConfiguratorTitle']));
        $fields->addFieldToTab('Root.Shop',new Tabset('Main','Main'));

        $fields->addFieldToTab('Root.Shop.Main',new Tab('Orders','Bestellung'));
        $fields->addFieldsToTab('Root.Shop.Main.Orders',[
          HeaderField::create('OrdersTitle','Bestellung Seite',3),
          CompositeField::create(
          [
            HTMLEditorField::create('Conditions',$this->owner->fieldLabels()['Conditions']),
            HTMLEditorField::create('ExistingNumberLabel',$this->owner->fieldLabels()['ExistingNumberLabel']),
            TextField::create('MobileStepTitle',$this->owner->fieldLabels()['MobileStepTitle']),
            HTMLEditorField::create('MobileStepBody',$this->owner->fieldLabels()['MobileStepBody']),
            TextField::create('WishNumberTitle',$this->owner->fieldLabels()['WishNumberTitle']),
            HTMLEditorField::create('WishNumberBody',$this->owner->fieldLabels()['WishNumberBody']),
            TreeDropdownField::create('AGBPageID',$this->owner->fieldLabels()['AGBPage'], SiteTree::class),
            TreeDropdownField::create('MobileAGBPageID',$this->owner->fieldLabels()['MobileAGBPage'], SiteTree::class)
          ])
        ]
        );


       $fields->addFieldToTab('Root.Shop.Main',new Tab('Emails','E-Mails'));
       $fields->addFieldsToTab('Root.Shop.Main.Emails',[
        HeaderField::create('OrderEmailTitle','Bestätigungsemail',3),
        CompositeField::create(
        [
          TextField::create('OrderEmailSender',$this->owner->fieldLabels()['OrderEmailSender']),
          TextField::create('OrderEmailSubject',$this->owner->fieldLabels()['OrderEmailSubject']),
          HTMLEditorField::create('OrderEmailBody',$this->owner->fieldLabels()['OrderEmailBody']),
          TextField::create('UnknownDoseEmailSender',$this->owner->fieldLabels()['UnknownDoseEmailSender']),
          TextField::create('UnknownDoseEmailSubject',$this->owner->fieldLabels()['UnknownDoseEmailSubject']),
          HTMLEditorField::create('UnknownDoseEmailContent',$this->owner->fieldLabels()['UnknownDoseEmailContent'])
        ])
      ]
      );
       
    }


    public function parseString($string,$order=null)
    {


        $variables = array(
            '$SiteName'       => $this->owner->Title,
            '$Datum'          => date('d.m.Y'),
            '$Aufschaltgebühr' => DBCurrency::create()->setValue($this->owner->ActivationPrice)->Nice()
            // '$LoginLink'      => Controller::join_links(
            //     $absoluteBaseURL,
            //     singleton(Security::class)->Link('login')
            // ),
           
        );
        if ($order){
           foreach (array('Name', 'Vorname', 'Email','Gender','Price') as $field) {
              $variables["\$Order.$field"] = $order->$field;
           }
           if ($order->Customer()){
              foreach (array('Gender','Name','FirstName','Email', 'Birthdate','Address','City','PostalCode') as $field) {
                 $variables["\$Customer.$field"] = $order->Customer()->$field;
              }
           

              foreach (array('printAddress','printTitle') as $method) {
                 $variables["\$Customer.$method"] = $order->Customer()->{$method}();
              }
           }
        }


        
        

        return str_replace(array_keys($variables), array_values($variables), $string);
    }
  


}