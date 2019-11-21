<?php 

use SilverStripe\Security\Member;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Security\Group;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Forms\EmailField;

class CustomEmail extends DataObject {
	private static $db = [
       'Title' => 'Varchar',
       'Subject' => 'Varchar',
       'Sender' => 'Varchar',
       'Receiver' => 'Varchar',
       'Body' => 'HTMLText',
       'Receivers' => 'Varchar',
       'Sent' => 'Boolean(0)'
	];

  private static $many_many = ['Attachments' => File::class];

  private static $many_many_extraFields = ['Attachments' => ['SortOrder' => 'Int']];
   
  private static $summary_fields = ['Title'];

  private static $owns = ['Attachments'];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = _t(__CLASS__.".Title",'Titel (intern)');
        $labels['Subject'] = _t(__CLASS__.".Subject",'Betreff');
        $labels['Sender'] = _t(__CLASS__.".Sender",'Sender');
        $labels['Receiver'] = _t(__CLASS__.".Receiver",'Empfänger (komma getrennt)');
        $labels['Body'] = _t(__CLASS__.".Body",'Inhalt');
        $labels['Receivers'] = _t(__CLASS__.".Receivers",'Empfängerlist');

		return $labels;

	}	


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Body');
    $fields->removeByName('Attachments');
    $fields->removeByName('Receivers');
    $fields->removeByName('Sent');
    $fields->replaceField('Sender',EmailField::create('Sender'));
    $fields->addFieldToTab('Root.Main',HTMLEditorField::create('Body',_t(__CLASS__.".Body",'Inhalt'))->setRows(5));
    $fields->insertAfter('Sender',DropdownField::create('Receivers',$this->fieldLabels()['Receivers'],['koeche' => 'Köche','kunden' => 'Kunden','custom' => 'Benutzerdefinierte'])->setEmptyString('Bitte wählen'));
    $fields->addFieldToTab('Root.Main',SortableUploadField::create('Attachments',$this->fieldLabels()['Attachments'])->setIsMultiUpload(true)->setFolderName("Uploads/CustomEmail"));
    $fields->FieldByName('Root.Main.Receiver')->displayIf('Receivers')->isEqualTo('custom')->end();
		return $fields;
	}

  public function getCMSValidator(){
      return new RequiredFields(
      'Title',
      'Subject',
      'Sender'
      );
  }




    public function createMail(){
      $mail = new Email();
      
     
      $mail->setFrom($this->Sender);
      $mail->setHTMLTemplate('Emails/simple_email');
      
      foreach ($this->Attachments() as $file) {
        $mail->addAttachment(dirname(__FILE__).'/../../..'.$file->getURL(),$file->Name);
      }
      return $mail;
    }


    public function sendEmail(){
     
      switch($this->Receivers){
        case "koeche":
          foreach(Cook::get()->filter('Status','approved') as $cook){
            if ($cook->Member()->Email){
              $email = $this->createMail();
              $email->setTo($cook->Member()->Email);
              $email->setSubject($this->getParsedString($this->Subject,$cook));
              $email->setBody($this->getParsedString($this->Body,$cook));
              $email->send();
            }
          }
          break;
        case "kunden":
          foreach(Customer::get() as $customer){
            if ($customer->Member()->Email){
              $email = $this->createMail();
              $email->setTo($customer->Member()->Email);
              $email->setSubject($this->getParsedString($this->Subject,$customer));
              $email->setBody($this->getParsedString($this->Body,$customer));
              $email->send();
            }
          }
          break;
        case "custom":
          foreach(explode(",",$this->Receiver) as $receiver){
            $email = $this->createMail();
            $email->setTo($receiver);
            $email->setSubject($this->getParsedString($this->Subject));
            $email->setBody($this->getParsedString($this->Body));
            $email->send();
          }
          break;
      }
      $this->Sent = 1;
      $this->write();
    }

    public function sendPreviewEmail(){
      $config = SiteConfig::current_site_config();
      $email = $this->createMail();
      $email->setSubject($this->getParsedString($this->Subject));
      $email->setBody($this->getParsedString($this->Body));
      $email->setTo($config->Email);
      $email->setCC('guillaume.pacilly@deskall.ch');
      $email->send();
    }
    


    public function getParsedString($string,$receiver = null)
    {
        $member = $receiver;
        $created = null;
        /**
         * @var \SilverStripe\ORM\FieldType\DBDatetime $createdDateObj
         */
        if ($member){
           $createdDateObj = $member->obj('Created');
           $created = $createdDateObj->Nice();
        }

        $Missions = Mission::get()->filter('isVisible',1)->sort('Sort');


       

        $absoluteBaseURL = $this->BaseURL();
        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$LoginLink'      => Controller::join_links(
                $absoluteBaseURL,
                singleton(Security::class)->Link('login')
            ),
            '$LoginCook'      => '<a rel="noopener" href="'.Controller::join_links(
                $absoluteBaseURL,
                'login-fuer-mietkoeche'
            ).'" target="_blank">Hier können Sie einloggen</a>',
            '$NewMissions' => $this->renderWith('Emails/MissionsData',array('Missions' => $Missions))
            
        );
        if ($member){
           foreach (array('Name', 'FirstName', 'Surname', 'Email') as $field) {
              $variables["\$Member.$field"] = $member->$field;
          }
        }
       
        $this->extend('updateEmailVariables', $variables);

        return str_replace(array_keys($variables), array_values($variables), $string);
    }

    public function BaseURL()
    {
        $absoluteBaseURL = Director::absoluteBaseURL();
        $this->extend('updateBaseURL', $absoluteBaseURL);
        return $absoluteBaseURL;
    }

}