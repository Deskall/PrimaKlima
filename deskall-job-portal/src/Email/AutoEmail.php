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

class AutoEmail extends DataObject {
	private static $db = [
       'Title' => 'Varchar',
       'Subject' => 'Varchar',
       'Sender' => 'Varchar',
       'Receiver' => 'Varchar',
       'Body' => 'HTMLText'
	];

   

    private static $summary_fields = ['Title'];

	public function fieldLabels($includerelation = true){
		$labels = parent::fieldLabels($includerelation);
		$labels['Title'] = _t(__CLASS__.".Title",'Titel (intern)');
        $labels['Subject'] = _t(__CLASS__.".Subject",'Betreff');
        $labels['Sender'] = _t(__CLASS__.".Sender",'Sender');
          $labels['Receiver'] = _t(__CLASS__.".Receiver",'Empfänger');
        $labels['Body'] = _t(__CLASS__.".Body",'Inhalt');

		return $labels;

	}	


	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Body');
        $fields->addFieldToTab('Root.Main',HTMLEditorField::create('Body',_t(__CLASS__.".Body",'Inhalt'))->setRows(5));

		return $fields;
	}




    public function createMail($body,$mission = null, $receiver = null){
       
        $to = ($receiver) ? $receiver->Email : $this->Receiver;
        $mail = new MissionEmail(CookConfig::get()->first(),$mission,$this->Sender,$to,$this->Subject, $this->Body);
        
        return $mail;
    }
    


    public function getParsedString($string,$receiver,$data)
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
       

        $absoluteBaseURL = $this->BaseURL();
        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$LoginLink'      => Controller::join_links(
                $absoluteBaseURL,
                singleton(Security::class)->Link('login')
            ),
            '$MissionData' => $data
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