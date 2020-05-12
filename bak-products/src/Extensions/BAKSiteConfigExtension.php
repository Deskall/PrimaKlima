<?php 

namespace BAK\Products;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;

class BAKSiteConfigExtension extends DataExtension 
{

  private static $db = [
    
    'SubjectEmail' => 'Varchar(255)',
    'ContentEmail' => 'Varchar(255)',

    'SubjectEmailConfirmation' => 'Varchar(255)',
    'ContentEmailConfirmation' => 'Varchar(255)',


    'EmailSentFrom' => 'Varchar(255)',
    'ReceiverEmail' => 'Varchar(255)',
  ];

  private static $has_one = [
    'ConfirmationPage' => SiteTree::class
  ];

  public function updateCMSFields(FieldList $fields) {
     

    //ADDRESS
    $fields->addFieldsToTab('Root.Produkte',[
      new TextField("ReceiverEmail", "E-Mail Adressen Empfänger (kommagetrennt)"),
      new TextField("SubjectEmail", "E-Mail Betreff"),
      new TextareaField("ContentEmail", "E-Mail Inhalt")),
      new EmailField('EmailSentFrom', 'E-Mail Absender'),
      new TextField("SubjectEmailConfirmation", "Email Betreff Bestätigung"),
      new TextareaField("ContentEmailConfirmation", "Email Inhalt Bestätigung"),
      TreeDropdownField::create('ConfirmationPageID','Produktformular Bestätigung Seite',SiteTree::class)
    ]);
    
  }

  
}