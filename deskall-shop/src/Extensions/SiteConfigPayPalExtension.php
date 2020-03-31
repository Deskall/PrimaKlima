<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Assets\File;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\CMS\Model\SiteTree;

class SiteConfigPayPalExtension extends DataExtension 
{

  private static $db = [
    'PayPalClientID' => 'Varchar',
    'PayPalSecret' => 'Varchar',
    'CustomerAccountLabel' => 'HTMLText',
    'BillPayLabel' => 'HTMLText',
    'OnlinePayLabel' => 'HTMLText',
    'PaymentConfirmedLabel' => 'HTMLText',
    'ClientNumberOffset' => 'Int',
    'OrderNumberOffset' => 'Int',
    'BuySuccessfullMessage' => 'HTMLText',
    'BillEmailSubject' => 'Varchar',
    'BillEmailBody' => 'HTMLText',
    'PaymentEmailSubject' => 'Varchar',
    'PaymentEmailBody' =>  'HTMLText',
    'TransportPrice' => 'Currency',
    'DeliveryLabel' => 'HTMLText',
    'MwSt' => 'Varchar',
    'FootertextProduct' => 'HTMLText'
  
  ];

  private static $has_one = [
     'BillFile' => File::class,
     'AGBFile' => File::class,
     'ReceiptFile' => File::class,
     'ShopPage' => SiteTree::class
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
     $labels['ClientNumberOffset'] = _t(__CLASS__.'.ClientNumberOffset','Increment für Kundennummer');
     $labels['OrderNumberOffset'] = _t(__CLASS__.'.OrderNumberOffset','Increment für Bestellungsnummer');
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
     $labels['TransportPrice'] = _t(__CLASS__.'.TransportPrice','standard Transportkosten');
     $labels['MwSt'] = _t(__CLASS__.'.MwSt','% MwSt.');
     $labels['FootertextProduct'] = _t(__CLASS__.'.FootertextProduct','standard Text für den Produkt-Seite Footer');
     $labels['ShopPage'] = _t(__CLASS__.'.ShopPage','Webshop Hauptseite');
     $labels['DeliveryLabel'] = _t(__CLASS__.'.DeliveryLabel','Lieferbedingungen');
  }

  public function updateCMSFields(FieldList $fields) {
     
    $fields->addFieldsToTab('Root.Shop',[
      
      TextField::create('PayPalClientID'),
      TextField::create('PayPalSecret'),
      CurrencyField::create('TransportPrice',$this->owner->fieldLabels()['TransportPrice']),
       HTMLEditorField::create('DeliveryLabel',$this->owner->fieldLabels()['DeliveryLabel'])->setRows(2),
      TextField::create('MwSt',$this->owner->fieldLabels()['MwSt']),
      TreeDropdownField::create('ShopPageID',$this->owner->fieldLabels()['ShopPage'],SiteTree::class),
      NumericField::create('ClientNumberOffset',$this->owner->fieldLabels()['ClientNumberOffset']),
      NumericField::create('OrderNumberOffset',$this->owner->fieldLabels()['OrderNumberOffset']),
      HTMLEditorField::create('FootertextProduct',$this->owner->fieldLabels()['FootertextProduct'])->setRows(5),
      HTMLEditorField::create('BillPayLabel',$this->owner->fieldLabels()['BillPayLabel'])->setRows(5),
      HTMLEditorField::create('OnlinePayLabel',$this->owner->fieldLabels()['OnlinePayLabel'])->setRows(5),
      TextField::create('BillEmailSubject',$this->owner->fieldLabels()['BillEmailSubject']),
      HTMLEditorField::create('BillEmailBody',$this->owner->fieldLabels()['BillEmailBody'])->setRows(5),
      TextField::create('PaymentEmailSubject',$this->owner->fieldLabels()['PaymentEmailSubject']),
      HTMLEditorField::create('PaymentEmailBody',$this->owner->fieldLabels()['PaymentEmailBody'])->setRows(5),
      UploadField::create('AGBFile',$this->owner->fieldLabels()['AGBFile'])->setFolderName('Uploads/Vorlagen'),
      UploadField::create('BillFile',$this->owner->fieldLabels()['BillFile'])->setFolderName('Uploads/Vorlagen'),
      UploadField::create('ReceiptFile',$this->owner->fieldLabels()['ReceiptFile'])->setFolderName('Uploads/Vorlagen')
    ]);
   
  }

  
}