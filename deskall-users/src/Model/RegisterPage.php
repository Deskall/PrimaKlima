<?php

use SilverStripe\Security\Group;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\HeaderField;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class RegisterPage extends Page {
	private static $db = array (
        'EmailValidationRequired' => 'Boolean(0)',
        'ApprovalRequired' => 'Boolean(0)',
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

        //Step 3
        'AfterCheckEmailFrom'                => 'Varchar(255)',
        'AfterAcceptationEmailSubject'             => 'Varchar(255)',
        'AfterAcceptationEmailBody'            => 'HTMLText',
        'AfterRefusalEmailSubject'             => 'Varchar(255)',
        'AfterRefusalEmailBody'            => 'HTMLText',

        'EmailFrom'                => 'Varchar(255)',
       
        'AlreadyConnected'         => 'HTMLText',
        'ApprovalEmailSender'      => 'Varchar',
        'ApprovalEmailReceiver'      => 'Varchar',
        'ApprovalEmailSubject'     => 'Varchar',
        'ApprovalEmailBody'        => 'HTMLText',
    );

    private static $has_one = ['Group' => Group::class];

    public function getCMSFields(){
    	$fields = parent::getCMSFields();
    	$fields->addFieldsToTab('Root.Registration',[
            DropdownField::create('GroupID',_t(__CLASS__.'.Group','Benutzer Grupp'), Group::get()->filter('Code',$this->stat('groupcodes'))->map('ID','Title'))->setEmptyString('Grupp wählen'),
            CheckboxField::create('EmailValidationRequired',_t(__CLASS__.'.EmailValidationRequired','Email Prüfung erfordert?')),
            CheckboxField::create('ApprovalRequired',_t(__CLASS__.'.ApprovalRequired','Genehmigung erfordert?')),
            HeaderField::create('InscriptionTitle',_t(__CLASS__.".BackInscriptionTitle","Inscription - Step 1"),3),
            CompositeField::create([    
                TextField::create('AfterRegistrationTitle',_t(__CLASS__.".AfterRegistrationTitle", 'Page title (after first step registration)')),
                HTMLEditorField::create('AfterRegistrationContent',_t(__CLASS__.".AfterRegistrationContent", 'Page content (after first step registration)')),
                TextField::create('AfterRegistrationEmailFrom',_t(__CLASS__.".AfterRegistrationEmailFrom", 'Validation Email sender')),
                TextField::create('AfterRegistrationEmailSubject',_t(__CLASS__.".AfterRegistrationEmailSubject", 'Validation email subject')),
                HTMLEditorField::create('AfterRegistrationEmailBody',_t(__CLASS__.".AfterRegistrationContent", 'Validaiton email body')),
            ]),
           Wrapper::create(HeaderField::create('InscriptionTitle2',_t(__CLASS__.".BackInscriptionTitle2","Inscription - Step 2"),3))->displayIf('EmailValidationRequired')->isChecked()->end(),
           Wrapper::create(CompositeField::create([    
                TextField::create('AfterConfirmationTitle',_t(__CLASS__.".AfterConfirmationTitle", 'Page title (after email validation)')),
                HTMLEditorField::create('AfterConfirmationContent',_t(__CLASS__.".AfterConfirmationContent", 'Page content (after email validation)')),
                TextField::create('AfterConfirmationEmailFrom',_t(__CLASS__.".AfterConfirmationEmailFrom", 'Confirmation email sender')),
                TextField::create('AfterConfirmationEmailSubject',_t(__CLASS__.".AfterConfirmationEmailSubject", 'Confirmation email subject')),
                HTMLEditorField::create('AfterConfirmationEmailBody',_t(__CLASS__.".AfterConfirmationContent", 'Confirmation email body')),
            ]))->displayIf('EmailValidationRequired')->isChecked()->end(),
            Wrapper::create(HeaderField::create('InscriptionTitle3',_t(__CLASS__.".BackInscriptionTitle","Inscription - Step 3"),3))->displayIf('ApprovalRequired')->isChecked()->end(),
            Wrapper::create(CompositeField::create([
                TextField::create('ApprovalEmailSender',_t(__CLASS__.".ApprovalEmailSender", 'Approval request email sender')),
                TextField::create('ApprovalEmailReceiver',_t(__CLASS__.".ApprovalEmailSReceiver", 'Approval request email receiver')),
                TextField::create('ApprovalEmailSubject',_t(__CLASS__.".ApprovalEmailSubject", 'Approval request email subject')),
                HTMLEditorField::create('ApprovalEmailBody',_t(__CLASS__.".ApprovalEmailBody", 'Approval request email body'))
            ]))->displayIf('ApprovalRequired')->isChecked()->end(),
            Wrapper::create(HeaderField::create('InscriptionTitle4',_t(__CLASS__.".BackInscriptionTitle","Inscription - Step 4"),3))->displayIf('ApprovalRequired')->isChecked()->end(),
            Wrapper::create(CompositeField::create([
                TextField::create('EmailFrom',_t(__CLASS__.".EmailFrom", 'Sender')),
                TextField::create('AfterAcceptationEmailSubject',_t(__CLASS__.".AfterAcceptationEmailSubject", 'Email subject (approval)')),
                HTMLEditorField::create('AfterAcceptationEmailBody',_t(__CLASS__.".AfterAcceptationEmailBody", 'Email body (approval)')),
                 TextField::create('AfterRefusalEmailSubject',_t(__CLASS__.".AfterRefusalEmailSubject", 'Email subject (refusal)')),
                HTMLEditorField::create('AfterRefusalEmailBody',_t(__CLASS__.".AfterRefusalEmailBody", 'Email body (refusal)'))
            ]))->displayIf('ApprovalRequired')->isChecked()->end(),
    		
            HTMLEditorField::create('AlreadyConnected',_t(__CLASS__.".AlreadyConnected", 'Content to show for connected User')),
            
    		]
    	);

    	$fields->FieldByName('Root.Registration')->setTitle(_t(__CLASS__.".RegistrationTab",'Registration Parameters'));

    	return $fields;
    }

    public function canCreate( $member = null, $context = []){
       return true;
    }
}