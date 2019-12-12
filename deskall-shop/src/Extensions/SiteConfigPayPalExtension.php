<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;

class SiteConfigPayPalExtension extends DataExtension 
{

  private static $db = [
    'PayPalClientID' => 'Varchar',
    'PayPalSecret' => 'Varchar',
    'CustomerAccountLabel' => 'HTMLText',
    'BillPayLabel' => 'HTMLText',
    'OnlinePayLabel' => 'HTMLText',
    'PaymentConfirmedLabel' => 'HTMLText',
    'BillEmailSubject' => 'Varchar',
    'BillEmailBody' => 'HTMLText',
    'PaymentEmailSubject' => 'Varchar',
    'PaymentEmailBody' =>  'HTMLText',
    'OrderNumberOffset' => 'Int',
    'BuySuccessfullMessage' => 'HTMLText'
  ];

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

  public function updateFieldLabels(&$labels){
  	 $labels['PayPalClientID'] = _t(__CLASS__.'.PayPalClientID','PayPal Kunden ID');
     $labels['PayPalSecret'] = _t(__CLASS__.'.PayPalSecret','PayPal Kunden Secret');
     $labels['CustomerAccountLabel'] = _t(__CLASS__.'.CustomerAccountLabel','Text für das Kundenkonto Label');
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
  }

  public function updateCMSFields(FieldList $fields) {
     
    $fields->addFieldsToTab('Root.Shop',[
      
      TextField::create('PayPalClientID'),
      TextField::create('PayPalSecret'),
      UploadField::create('AGBFile',$this->owner->fieldLabels()['AGBFile'])->setFolderName('Uploads/Vorlagen'),
      UploadField::create('BillFile',$this->owner->fieldLabels()['BillFile'])->setFolderName('Uploads/Vorlagen'),
      UploadField::create('ReceiptFile',$this->owner->fieldLabels()['ReceiptFile'])->setFolderName('Uploads/Vorlagen')
    ]);
   
  }

  
}