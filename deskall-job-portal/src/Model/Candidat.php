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
use SilverStripe\Forms\TextField;
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
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Permission;
use SilverStripe\SiteConfig\SiteConfig;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-users
 */
class Candidat extends DataObject
{
    private static $db = array(
        'Gender'  => 'Varchar',
        'Description' => 'Text',
        'Birthdate'  => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'Phone'  => 'Varchar',
        'Experience' => 'HTMLText',
        'Formation' => 'HTMLText',
        'ProfilCompletion' => 'Float'
     );

    private static $singular_name = "Kandidat";
    private static $plural_name = "Kandidaten";

   

    private static $required_profile_fields = ['Gender','Surname','FirstName','Birthdate','Email', 'Address','PostalCode','City','Country','Phone'];

    private static $groupcode = 'kandidaten';

    private static $default_sort = ['Created' => 'DESC'];

    private static $has_one = [
        'Member' => Member::class,
        'Picture' => Image::class,
        'CV' => File::class,
        'MotivationLetter' => File::class
    ];

    private static $has_many = [
        'CVItems' => CVItem::class,
        'CursusItems' => CursusItem::class,
        'Candidatures' => Candidature::class,
        'Parameters' => AssignedProfilParameter::class
    ];

    private static $owns = [
        'Picture','CV','MotivationLetter','Files'
    ];



    private static $many_many = [
        'Files' => File::class
    ];

     private static $many_many_extraFields = [
        'Files' => ['SortOrder' => 'Int']
    ];

    private static $summary_fields = [
        'printActivity' => ['title' => 'Aktive Aufträge'],
        'Thumbnail',
        'Member.FirstName' => ['title' => 'Vorname'],
        'Member.Surname' => ['title' => 'Name'],
        'Member.Email' => ['title' => 'Email'],
        'Phone',
        'City',
        'Country',
        'NiceJobs' => ['title' => 'Berufe'],
        'Created' => ['title' => 'Registriert seit']
    ];

    private static $searchable_fields = [
        'Member.FirstName',
        'Member.Surname',
        'Member.Email',
        'City',
        'Country'
    ];

    private static $cascade_deletes = ['Member','Picture','CVItems','CursusItems','Candidatures','Files','CV','MotivationLetter'];


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
    $labels['Files'] = _t(__CLASS__.'.Files','Laden Sie hier Ihre Dateien.');
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
    $labels['isApproved'] = _t('CustomUser.isApproved','diese Benutzer genehmigen?');
    $labels['CVItems'] = _t('CustomUser.CVItems','Erfahrungen');
    $labels['CursusItems'] = _t('CustomUser.CursusItems','Ausbildungen');
    $labels['ProfilCompletion'] = _t('CustomUser.ProfilCompletion','Prozent Profil abgeschlossen');
    return $labels;
    }


    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->calculateCompletion();
        if ($this->Picture()->exists()){
            $folder = Folder::find_or_make($this->generateFolderName());
            $this->Picture()->ParentID = $folder->ID;
            $this->Picture()->write();
            $this->Picture()->publishSingle();
        }
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
       // $fields->removeByName('Permissions');
       // $fields->removeByName('Jobs');
       // $fields->removeByName('Categories');
       // $fields->removeByName('isActive');
       // $fields->removeByName('isApproved');
       // $fields->removeByName('isRefused');
       // $fields->removeByName('Password');
       // $fields->removeByName('FailedLoginCount');
       // $fields->removeByName('Locale');
       // $fields->removeByName('BlogPosts');
       // $fields->removeByName('BlogProfileSummary');
       // $fields->removeByName('BlogProfileImage');
       // $fields->removeByName('Status');
       // $fields->removeByName('DirectGroups');
       // $fields->removeByName('oldID');
       // $fields->removeByName('DirectGroups');
       // $fields->removeByName('Files');
       // $fields->removeByName('CV');
       // $fields->removeByName('Ausweis');
       // $fields->removeByName('Licence');
       // $fields->removeByName('A1Form');
       // $fields->removeByName('HACCPCertificat');
       // $fields->removeByName('TaxResidenceCertificat');
       // // $fields->insertBefore('FirstName',$fields->FieldByName('Root.Main.Picture'));
       // $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.MainTab','Persönliche Daten'));
       // $fields->FieldByName('Root.Main.Picture')->setIsMultiUpload(false)->setFolderName($this->generateFolderName());
       
       // $fields->replaceField('Birthdate',DateField::create('Birthdate'));
       // $fields->replaceField('Gender',DropdownField::create('Gender',$this->fieldLabels()['Gender'],['Herr' => _t(__CLASS__.'.GenderH', 'Herr'),'Frau' => _t(__CLASS__.'.GenderF', 'Frau')])->setEmptyString(_t(__CLASS__.'.GenderLabel','Anrede wählen')));
       // $fields->replaceField('Country',DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));
        
       // $fields->addFieldsToTab('Root.Berufserfahrung',[
       //  CheckboxSetField::create('Jobs',$this->fieldLabels()['Jobs'],CookJob::get()->map('ID','Title')),
       //  CheckboxSetField::create('Categories',$this->fieldLabels()['Categories'],CookType::get()->map('ID','Title')),
       //  $fields->FieldByName('Root.Main.Experience'),
       //  $fields->FieldByName('Root.Main.Formation')
       // ]);

       // $fields->addFieldsToTab('Root.Unterlagen',[
       //  UploadField::create('CV',$this->fieldLabels()['CV'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
       //  UploadField::create('Ausweis',$this->fieldLabels()['Ausweis'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
       //  UploadField::create('Licence',$this->fieldLabels()['Licence'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
       //  UploadField::create('HACCPCertificat',$this->fieldLabels()['HACCPCertificat'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
       //  UploadField::create('A1Form',$this->fieldLabels()['A1Form'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
       //  UploadField::create('TaxResidenceCertificat',$this->fieldLabels()['TaxResidenceCertificat'])->setIsMultiUpload(false)->setFolderName($this->generateFolderName()),
       //  SortableUploadField::create('Files',$this->fieldLabels(true)['Files'])->setIsMultiUpload(true)->setFolderName($this->generateFolderName()),

       // ]);




       return $fields;
    }

    // public function NiceJobs(){
    //     $jobs = '';
    //     $i = 1;
    //     foreach($this->Jobs() as $job){
    //         $jobs .= $job->Title;
    //         if ($i != $this->jobs()->count() ){
    //             $jobs .= ', ';
    //         } 
    //     }
    //     return $jobs;
    // }

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

    // public function NiceTyp(){
    //     $types = '';
    //     $i = 1;
    //     foreach($this->Categories() as $type){
    //         $types .= $type->Title;
    //         if ($i != $this->Categories()->count() ){
    //             $types .= ', ';
    //         } 
    //     }
    //     return $types;
    // }

    public function NiceAddress(){
        $html = '<p>'.$this->Member()->FirstName.' '.$this->Member()->Surname.'<br/>';
        if ($this->Address){
            $html .= $this->Address.'<br/>';
        }
        if ($this->PostalCode){
            $html .= $this->PostalCode.' - ';
        }
        if ($this->City){
            $html .= $this->City.'<br/>';
        }
        if ($this->Country){
           $html .=  i18n::getData()->getCountries()[$this->Country].'<br/>';
        }
        $html .= '<a href="mailto:'.$this->getEmail().'">'.$this->getEmail().'</a>'.'<br/>';
        if ($this->Telefon){
            $html .= $this->Telefon;
        }
        $html .= '</p>';
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

    public function getEmail(){
        return $this->Member()->Email;
    }

    public function getAge(){
        $Birthdate = new \DateTime($this->Birthdate);
        $today = new \DateTime();
        return $today->diff($Birthdate)->format('%y').' '._t('Candidat.Years','Jahre alt') ;
    }

    


    public function getProfileFields(){
        $CVField = new GridField(
            'CVItems',
            _t('KOCH.ProfessionalExperiences', 'Berufliche Erfahrungen'),
            $this->CVItems(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('Sort'))
        );
        $CVField->addExtraClass('frontendgrid');
        $CVField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
            'StartDate' => array(
                'title' => _t('KOCH.StartDate', 'Von'),
                'callback' => function ($record, $column, $holiDayGridfield){
                    return DateField::create('StartDate', _t('KOCH.StartDate', 'Von'));
                }
            ),
            'EndDate' => array(
                'title' => _t('KOCH.EndDate', 'Bis'),
                'callback' => function ($record, $column, $holiDayGridfield){
                    return DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'));
                }
            ),
            'Company' => array (
                'title' => _t('KOCH.Company', 'Firma'),
                'callback' => function ($record, $column){
                    return TextField::create('Company', _t('KOCH.Company', 'Firma'));
                }
            ),
            'Position' => array (
                'title' => _t('KOCH.Position', 'Position'),
                'callback' => function ($record, $column){
                    return TextField::create('Position', _t('KOCH.Position', 'Position'))->setAttribute('list','position-suggestions');
                }
            ),
            'Description' => array (
                'title' => _t('KOCH.Description', 'Job-Beschreibung'),
                'callback' => function ($record, $column){
                    return TextareaField::create('Description', _t('KOCH.Description', 'Job-Beschreibung'))->setRows(3);
                }
            )
        ));

        $CursusField = new GridField(
            'CursusItems',
            $this->fieldLabels()['CursusItems'],
            $this->CursusItems(),
            GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('Sort'))
        );
        $CursusField->addExtraClass('frontendgrid');
        $CursusField->getConfig()->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
            'StartDate' => array(
                'title' => _t('KOCH.StartDate', 'Von'),
                'callback' => function ($record, $column, $holiDayGridfield){
                    return DateField::create('StartDate', _t('KOCH.StartDate', 'Von'));
                }
            ),
            'EndDate' => array(
                'title' => _t('KOCH.EndDate', 'Bis'),
                'callback' => function ($record, $column, $holiDayGridfield){
                    return DateField::create('EndDate', _t('KOCH.EndDate', 'Bis'));
                }
            ),
            'School' => array (
                'title' => _t('KOCH.School', 'Schule'),
                'callback' => function ($record, $column){
                    return TextField::create('School', _t('KOCH.School', 'Schule'));
                }
            ),
            'Diplom' => array (
                'title' => _t('KOCH.Diplom', 'Ausbildung'),
                'callback' => function ($record, $column){
                    return TextField::create('Diplom', _t('KOCH.Diplom', 'Ausbildung'));
                }
            )
        ));

       $fields = new FieldList(
            HiddenField::create('PictureID','Picture'),
            TextareaField::create('Description','Stellen Sie sich in wenigen Worten vor'),
            CompositeField::create(
                HeaderField::create('ExperienceTitle','Ihre beruflichen Erfahrungen',3),
                $CVField
            )->setName('ExperienceFields'),
            CompositeField::create(
             HeaderField::create('FormationTitle','Ihre Ausbildungen',3),
             $CursusField
            )->setName('FormationFields'),
            SortableUploadField::create('Files',$this->fieldLabels()['Files'])->setIsMultiUpload(true)->setFolderName($this->generateFolderName())
        );
        // //Files
        // $fields->push(HiddenField::create('CVID'));
        // $fields->push(HiddenField::create('LicenceID'));
        // $fields->push(HiddenField::create('HACCPCertificatID'));
        // $fields->push(HiddenField::create('AusweisID'));
        // $fields->push(HiddenField::create('A1FormID'));
        // $fields->push(HiddenField::create('TaxResidenceCertificatID'));

        // $fields->push(SortableUploadField::create('Files',$this->fieldLabels()['Files'])->setIsMultiUpload(true)->setFolderName($this->generateFolderName()));
        
        return $fields;
    }

    public function getRequiredProfileFields(){
        return new RequiredFields([]);
    }

    public function getAccountFields(){
            $date = new \DateTime();
            $date->modify('-18 years');
            $fields = new FieldList(
                DropdownField::create('Gender',$this->fieldLabels()['Gender'], ['Herr' => _t(__CLASS__.'.GenderH', 'Herr'),'Frau' => _t(__CLASS__.'.GenderF', 'Frau')])->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.GenderLabel','Anrede wählen')),
                TextField::create('Surname', _t('ARBEITGEBER.Surname', 'Name'))->setAttribute('class','uk-input'),
                TextField::create('FirstName', _t('ARBEITGEBER.FirstName', 'Vorname'))->setAttribute('class','uk-input'),
                DateField::create('Birthdate',$this->fieldLabels()['Birthdate'])->setAttribute('class','uk-input')->setMaxDate($date->format('Y-m-d')),
                TextField::create('Address', _t('ARBEITGEBER.AddressStreet', 'Adresse'))->setAttribute('class','uk-input'),
                TextField::create('PostalCode', _t('ARBEITGEBER.AddressPostalCode', 'PLZ'))->setAttribute('class','uk-input'),
                TextField::create('City', _t('ARBEITGEBER.AddressPlace', 'Ort'))->setAttribute('class','uk-input'),
                DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setValue('de')->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')),

                EmailField::create('Email', _t('ARBEITGEBER.Email', 'E-Mail'))->setAttribute('class','uk-input'),
                TextField::create('Phone', _t('ARBEITGEBER.Telephone', 'Telefon'))->setAttribute('class','uk-input')
            );

        return $fields;
    }

    public function getRequiredAccountFields(){
       
        return new RequiredFields(['Gender','Surname','FirstName','Birthdate','Email', 'Address','PostalCode','City','Country','Phone']);
    }

    public function getCompetencesFields(){
            
        $fields = new FieldList(
               
        );

        return $fields;
    }

    public function getRequiredCompetencesFields(){
       
        return new RequiredFields([]);
    }

    public function calculateCompletion(){
        /******* Rules ********
        * First the required fields: amount to 50%, each equal
        * then Experiences (at least one) 20%
        * then Formations (at least one) 20 %
        * then Profil parameters 10%, each equal (for now-->see Weighting System)
        */
        $percent = 0;

        $i = 0;
        $j = 0;
        $fields = $this->stat('required_profile_fields');
        foreach($fields as $key => $field){
            if ($this->{$field} != NULL || $this->Member()->{$field} != NULL){
                $j++;
            }
            $i++;
        }
        if ($this->Picture()->exists()){
            $j++;
        }
        $i++;

        $firstRowResult = ($j/$i) * 50;
        $secondRowResult = ($this->CVItems()->count() > 0) ? 20 : 0;
        $thirdRowResult = ($this->CursusItems()->count() > 0) ? 20 : 0;
       
        $activeParameters = ProfilParameter::get()->filterByCallback(function($item, $list) {
            return $item->isVisible && ($item->Values()->exists() || $item->FieldType == "range"); 
        });
        $k = 0;
        $l = 0; 
        foreach ($activeParameters as $ap) {
           if ($this->Parameters()->filter('Title',$ap->Title)->count() > 0){
            $l++;
           }
           $k++;
        }
        $fourthRowResult = ($l/$k) * 10;
        
        $percent = $firstRowResult + $secondRowResult + $thirdRowResult + $fourthRowResult;
        
        $this->ProfilCompletion = number_format($percent,2);
        
    }

    public function generateFolderName(){
        return "Uploads/Kandidaten/".$this->ID;
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

    //To delete or update
    public function sendApprovalEmail(){
        // $GroupID = Group::get()->filter('Code',$this->stat('groupcode'))->first()->ID; 
        // $page = RegisterPage::get()->filter('GroupID',$GroupID)->first();
        // $from = ($page && $page->EmailFrom) ? $page->EmailFrom : SiteConfig::current_site_config()->Email;
        // $body = new DBHTMLText();
        // $body->setValue($page->AfterAcceptationEmailBody);
        
        
        // $mail = new MemberEmail($page,$this->Member(),$from,$this->Email,$page->AfterAcceptationEmailSubject, $body);
        // $mail->send();
    }

    public function sendRefusalEmail(){
        $GroupID = Group::get()->filter('Code',$this->stat('groupcode'))->first()->ID; 
        $page = RegisterPage::get()->filter('GroupID',$GroupID)->first();
        $from = ($page && $page->EmailFrom) ? $page->EmailFrom : SiteConfig::current_site_config()->Email;
        $body = new DBHTMLText();
        $body->setValue($page->AfterRefusalEmailBody);
        
        $mail = new MemberEmail($page,$this->Member(),$from,$this->Email,$page->AfterRefusalEmailSubject,$body);
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

    public function printTitle(){
        return $this->Member()->FirstName.' '.$this->Member()->Surname;
    }

}