<?php


use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Tabset;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Security\Group;
use SilverStripe\Forms\FormAction;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\Member;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\i18n\i18n;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Assets\Folder;
use SilverStripe\ORM\DB;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\EmailField;


/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-users
 */
class CustomUser extends Member
{
    private static $db = array(
        'isActive' => 'Boolean(0)',
        'Company' => 'Varchar',
        'Gender'  => 'Varchar',
        'Birthdate'  => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'Fax'  => 'Varchar',
        'URL'  => 'Varchar',
        'Experience' => 'HTMLText',
        'Formation' => 'HTMLText',
        'Status' => 'Varchar',
        'oldID' => 'Int'
     );

    private static $singular_name = "Koch";
    private static $plural_name = "Köche";

    private static $register_fields = ['FirstName','Surname','Email','Password'];

    private static $required_profile_fields = ['FirstName','Surname','Email','Gender','Birthdate','Address','PostalCode','City','Country','Phone'];

    private static $groupcode = 'mietkoeche';

    private static $default_sort = ['isActive' => 'DESC','Surname' => 'ASC'];

    private static $has_one = [
        'Picture' => Image::class,
        'CV' => File::class,
        'Licence' => File::class,
        'HACCPCertificat' => File::class,
        'Ausweis' => File::class,
        'A1Form' => File::class,
        'TaxResidenceCertificat' => File::class
    ];

    private static $many_many = [
        'Files' => File::class,
        'Jobs' => CookJob::class,
        'Categories' => CookType::class
    ];

     private static $many_many_extraFields = [
        'Files' => ['SortOrder' => 'Int']
    ];

    private static $summary_fields = [
        'printActivity' => ['title' => 'Aktive Aufträge'],
        'Thumbnail',
        'FirstName',
        'Surname',
        'Email',
        'Phone',
        'City',
        'Country',
        'NiceJobs' => ['title' => 'Berufe'],
        'NiceTyp' => ['title' => 'Art'],
        'Created' => ['title' => 'Registriert seit']
    ];

    private static $searchable_fields = [
        'isActive',
        'FirstName',
        'Surname',
        'Email',
        'City',
        'Country'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['isActive'] = _t(__CLASS__.'.isActive','Aktive');
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['Gender'] = _t(__CLASS__.'.Gender','Anrede');
    $labels['Birthdate'] = _t(__CLASS__.'.Birthdate','Geburtsdatum');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Picture'] = _t(__CLASS__.'.Picture','Bild');
    $labels['Files'] = _t(__CLASS__.'.Files','Andere Dateien');
    $labels['Experience'] = _t(__CLASS__.'.Experience','Erfahrungen');
    $labels['Formation'] = _t(__CLASS__.'.Formation','Ausbildungen');
    $labels['Jobs'] = _t(__CLASS__.'.Jobs','Berufe');
    $labels['Categories'] = _t(__CLASS__.'.Categories','Küchenart');
    $labels['CV'] = _t(__CLASS__.'.CV','Lebenslauf/CV');
    $labels['Licence'] = _t(__CLASS__.'.Licence','Gewerbeschein');
    $labels['HACCPCertificat'] = _t(__CLASS__.'.HACCPCertificat','HACCP Bescheinigung');
    $labels['Ausweis'] = _t(__CLASS__.'.Ausweis','Personalausweis');
    $labels['A1Form'] = _t(__CLASS__.'.A1Form','A1 Formular von der Krankenkasse');
    $labels['TaxResidenceCertificat'] = _t(__CLASS__.'.TaxResidenceCertificat','Steueransässigkeitsbescheinigung vom Finanzamt');

    return $labels;
    }

    public function canDelete($member = null){
        if ($this->isActive){
            return false;
        }
        else{
            return parent::canDelete($member);
        }
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
        // if ($this->Picture()->exists()){
        //     $folder = Folder::find_or_make($this->generateFolderName());
        //     $this->Picture()->ParentID = $folder->ID;
        //     $this->Picture()->write();
        //     $this->Picture()->publishSingle();
        // }
        // foreach($this->Files() as $file){
        //     $file->publishSingle();
        // }
    }

    public function onAfterWrite()
    {
        if ($this->isChanged('PictureID')){
            $changedFields = $this->getChangedFields();
            $oldPicture = Image::get()->byId($changedFields['PictureID']['before']);
            if ($oldPicture){
                $oldPicture->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($oldPicture->ID));
                $oldPicture->delete();
            }
        }
        
        parent::onAfterWrite();
       
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('Permissions');
       $fields->removeByName('Jobs');
       $fields->removeByName('Categories');
       $fields->removeByName('isActive');
       $fields->removeByName('isApproved');
       $fields->removeByName('Password');
       $fields->removeByName('FailedLoginCount');
       $fields->removeByName('Locale');
       $fields->removeByName('BlogPosts');
       $fields->removeByName('BlogProfileSummary');
       $fields->removeByName('BlogProfileImage');
       $fields->removeByName('Status');
       $fields->removeByName('DirectGroups');
       $fields->removeByName('oldID');
       $fields->removeByName('DirectGroups');
       $fields->removeByName('Files');
       $fields->removeByName('CV');
       $fields->removeByName('Ausweis');
       $fields->removeByName('Licence');
       $fields->removeByName('A1Form');
       $fields->removeByName('HACCPCertificat');
       $fields->removeByName('TaxResidenceCertificat');
       $fields->insertBefore('FirstName',$fields->FieldByName('Root.Main.Picture'));
       $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.MainTab','Persönliche Daten'));
       $fields->FieldByName('Root.Main.Picture')->setIsMultiUpload(false)->setFolderName($this->generateFolderName());
       
       $fields->replaceField('Birthdate',DateField::create('Birthdate'));
       $fields->replaceField('Gender',DropdownField::create('Gender',$this->fieldLabels()['Gender'],['Sir' => _t(__CLASS__.'.GenderH', 'Herr'),'Miss' => _t(__CLASS__.'.GenderF', 'Frau')])->setEmptyString(_t(__CLASS__.'.GenderLabel','Anrede wählen')));
       $fields->replaceField('Country',DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));
        
       $fields->addFieldsToTab('Root.Berufserfahrung',[
        CheckboxSetField::create('Jobs',$this->fieldLabels()['Jobs'],CookJob::get()->map('ID','Title')),
        CheckboxSetField::create('Categories',$this->fieldLabels()['Categories'],CookType::get()->map('ID','Title')),
        $fields->FieldByName('Root.Main.Experience'),
        $fields->FieldByName('Root.Main.Formation')
       ]);

       $fields->addFieldsToTab('Root.Unterlagen',[
        UploadField::create('CV',$this->fieldLabels()['CV'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
        UploadField::create('Ausweis',$this->fieldLabels()['Ausweis'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
        UploadField::create('Licence',$this->fieldLabels()['Licence'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
        UploadField::create('HACCPCertificat',$this->fieldLabels()['HACCPCertificat'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
        UploadField::create('A1Form',$this->fieldLabels()['A1Form'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
        UploadField::create('TaxResidenceCertificat',$this->fieldLabels()['TaxResidenceCertificat'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
        SortableUploadField::create('Files',$this->fieldLabels(true)['Files'])->setIsMultiUpload(true)->setFolderName($this->generateFolderName()),

       ]);




       return $fields;
    }

    public function NiceJobs(){
        $jobs = '';
        $i = 1;
        foreach($this->Jobs() as $job){
            $jobs .= $job->Title;
            if ($i != $this->jobs()->count() ){
                $jobs .= ', ';
            } 
        }
        return $jobs;
    }

    public function Thumbnail(){
        if ($this->Picture()->exists()){
            $html = '<img src="'.$this->Picture()->ScaleHeight(200)->getURL().'" />';
        }
        else {
            $html = "(Keine Bild)";
        }
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

    public function NiceTyp(){
        $types = '';
        $i = 1;
        foreach($this->Categories() as $type){
            $types .= $type->Title;
            if ($i != $this->Categories()->count() ){
                $types .= ', ';
            } 
        }
        return $types;
    }

    public function NiceAddress(){
        $html = '<p>'.$this->getTitle().'<br/>'
        .$this->Company.'<br/>'
        .$this->Address.'<br/>'
        .$this->PostalCode.' - '.$this->City.'<br/>'
        .$this->Country.'</p>'
        .'<p><a href="mailto:'.$this->Email.'">'.$this->Email.'</a>'.'<br/>'
        .$this->Telefon.'</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

    public function getRegisterFields(){
        $fields = $this->getMemberFormFields();
        foreach($fields as $field){
            if (!in_array($field->Name,$this->stat('register_fields'))){
                $fields->removeByName($field->Name);
            }
            $fields->replaceField('Email',EmailField::create('Email',$this->fieldLabels()['Email']));
        }

        return $fields;
    }

    public function getRequiredRegisterFields(){
        return new RequiredFields(['FirstName','Surname','Email','Password']);
    }

    public function getProfileFields(){
        $fields = $this->getFrontEndFields();
        //Fields not needed
        $fields->removeByName(['TempIDHash','TempIDExpired','Password','AutoLoginHash','AutoLoginExpired','PasswordEncryption','Salt','PasswordExpiry','LockedOutUntil','Locale','FailedLoginCount','ValidationKey','NeedsValidation','isApproved','isRefused','URLSegment','BlogProfileSummary','BlogProfileImage','isActive']);
        //fields to replace
        $fields->removeByName(['Gender','Country','Picture']);
        $fields->insertBefore('FirstName',DropdownField::create('Gender',$this->fieldLabels()['Gender'], ['Sir' => _t(__CLASS__.'.GenderH', 'Herr'),'Miss' => _t(__CLASS__.'.GenderF', 'Frau')])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Anrede wählen')));
        $fields->push(HiddenField::create('PictureID'));
        $fields->insertBefore('Phone',DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));


        //Fields to adapt
        $fields->fieldByName('Birthdate')->setAttribute('class','flatpickr');
        $fields->fieldByName('Email')->setAttribute('type','email');
        $fields->fieldByName('URL')->setAttribute('type','url')->setAttribute('class','uk-input');


        //Files
        $fields->push(HiddenField::create('CVID'));
        $fields->push(HiddenField::create('LicenceID'));
        $fields->push(HiddenField::create('HACCPCertificatID'));
        $fields->push(HiddenField::create('AusweisID'));
        $fields->push(HiddenField::create('A1FormID'));
        $fields->push(HiddenField::create('TaxResidenceCertificatID'));

        $fields->push(SortableUploadField::create('Files',$this->fieldLabels()['Files'])->setIsMultiUpload(true)->setFolderName($this->generateFolderName()));
        $fields->push(HTMLEditorField::create('Experience',$this->fieldLabels()['Experience'])->setRows(5));
        $fields->push(HTMLEditorField::create('Formation',$this->fieldLabels()['Formation'])->setRows(5));
        $fields->push(CheckboxSetField::create('Jobs',$this->fieldLabels()['Jobs'],CookJob::get()->map('ID','Title'))->setAttribute('class','optionset checkboxset uk-column-1-2@s uk-column-1-3@l'));
        $fields->push(CheckboxSetField::create('Categories',$this->fieldLabels()['Categories'],CookType::get()->map('ID','Title'))->setAttribute('class','optionset checkboxset uk-column-1-2@s uk-column-1-3@l'));
        return $fields;
    }

    public function getRequiredProfileFields(){
        return new RequiredFields($this->stat('required_profile_fields'));
    }

    public function profileCompletion(){
        $i = 0;
        $j = 0;
        $fields = $this->stat('required_profile_fields');
        foreach($fields as $key => $field){
            if ($this->{$field} != NULL){
                $j++;
            }
            $i++;
        }
        $files = ['CV','Licence','HACCPCertificat','Ausweis'];
        foreach($files as $key => $file){
            if ($this->{$file}()->exists()){
                $j++;
            }
            $i++;
        }
        return number_format($j/$i*100,2);
    }

    public function generateFolderName(){
        return "Uploads/Koeche/".$this->ID;
    }

    public function Approve(){
        $this->isApproved = 1;
        $this->Status = "approved";
        $this->write();
        $this->sendApprovalEmail();
    }


    public function Refuse(){
        $this->isRefused = 1;
         $this->Status = "refused";
        $this->write();
        $this->sendRefusalEmail();
    }

    public function canApproveContract($mission){
        return ($mission->Candidatures()->filter('status','approved')->first()->CookID == $this->ID && $mission->Status != "approved");
    }

    public function sendApprovalEmail(){
        $page = RegisterPage::get()->first();
        $body = new DBHTMLText();
        $body->setValue($page->AfterAcceptationEmailBody);
        
        
        $mail = new MemberEmail($page,$this,$page->EmailFrom,$this->Email,$page->AfterAcceptationEmailSubject, $body);
        $mail->send();
    }

    public function sendRefusalEmail(){
        $page = RegisterPage::get()->first();
        $body = new DBHTMLText();
        $body->setValue($page->AfterRefusalEmailBody);
        
        $mail = new MemberEmail($page,$this,$page->EmailFrom,$this->Email,$page->AfterRefusalEmailSubject,$body);
        $mail->send();
    }

    public function ActiveMissions(){
        return Mission::get()->filter(['isActive' => 1,'CookID' => $this->ID])->sort('Start','DESC');
    }

  
    public function printActivity(){
        $html = '';
        if ($this->isActive){
            foreach ($this->ActiveMissions() as $m) {
               $html .= '<a href="'.$m->getCMSEditLink().'">'.$m->Job()->Title.' in '.$m->City.'</a><br/>';
            }
        }else{
            $html .= '(keine)';
        }
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

}