<?php


use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CheckboxField;
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
use SilverStripe\ORM\DataObject;
use SilverStripe\SiteConfig\SiteConfig;
use UncleCheese\DisplayLogic\Forms;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\DataList;

/**
 * Custom extension to adjust to project specific need
 * 
 * @package deskall-users
 */
class JobGiver extends DataObject
{
    private static $db = array(
        'Company' => 'Varchar',
        'Address'  => 'Varchar',
        'PostalCode'  => 'Varchar',
        'City'  => 'Varchar',
        'Country'  => 'Varchar',
        'CompanyEmail' => 'Varchar',
        'Phone'  => 'Varchar',
        'Fax'  => 'Varchar',
        'URL'  => 'Varchar',
        'Description' => 'HTMLText',
        'SocialFacebook' => 'Varchar(255)',
        'SocialTwitter' => 'Varchar(255)',
        'SocialInstagram' => 'Varchar(255)',
        'SocialPinterest' => 'Varchar(255)',
        'SocialXing' => 'Varchar(255)',
        'SocialLinkedin' => 'Varchar(255)',
        'ContactPersonFirstName' => 'Varchar(255)',
        'ContactPersonSurname' => 'Varchar(255)',
        'ContactPersonTelephone' => 'Varchar(255)',
        'ContactPersonMobile' => 'Varchar(255)',
        'ContactPersonEmail' => 'Varchar(255)',

        'BillingAddressIsCompanyAddress' => 'Boolean',
        'BillingAddressCompany' => 'Varchar(255)',
        'BillingAddressStreet' => 'Varchar(255)',
        'BillingAddressPostalCode' => 'Varchar(255)',
        'BillingAddressPlace' => 'Varchar(255)',
        'BillingAddressCountry' => 'Varchar(255)',      
        'Cipher' => 'Varchar(255)', 
        'ReasonWhy' => 'HTMLText',  
        'FlatrateEndDate' => 'Date',
        'Nummer' => 'Varchar'
     );

    private static $singular_name = "Arbeitgeber";
    private static $plural_name = "Arbeitgeber";

    private static $groupcode = 'arbeitgeber';

    private static $default_sort = ['Created' => 'DESC'];

    private static $has_one = [
        'Member' => Member::class,
        'Logo' => Image::class
    ];

    private static $has_many = [
        'Missions' => Mission::class,
        'Orders' => ShopOrder::class,
        'Queries' => MatchingQuery::class
    ];

    private static $defaults = [
        'BillingAddressIsCompanyAddress' => 1
    ];

    private static $cascade_deletes = ['Member','Logo','Missions','Orders'];

   private static $summary_fields = array(
        'Created' => 'Registriert seit',
        'Nummer' => 'Kundennummer',
        'Company' => 'Firma',
        'City' => 'Ort',
    );

    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
     $labels['Created'] = _t(__CLASS__.'.Created','Erstellt am');
    $labels['Company'] = _t(__CLASS__.'.Company','Firma');
    $labels['CompanyEmail'] = _t(__CLASS__.'.CompanyEmail','E-Mail-Adresse der Firma');
    $labels['ContactPersonFirstName'] = _t(__CLASS__.'.ContactPersonFirstName','Ansprechparter Vorname');
    $labels['ContactPersonSurname'] = _t(__CLASS__.'.ContactPersonSurname','Ansprechparter Name');
    $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
    $labels['PostalCode'] = _t(__CLASS__.'.PostalCode','PLZ');
    $labels['City'] = _t(__CLASS__.'.City','Stadt');
    $labels['Country'] = _t(__CLASS__.'.Country','Land');
    $labels['BillingAddressCompany'] = _t(__CLASS__.'.BillingAddressCompany','Firma');
    $labels['BillingAddressStreet'] = _t(__CLASS__.'.BillingAddressStreet','Adresse');
    $labels['BillingAddressPostalCode'] = _t(__CLASS__.'.BillingAddressPostalCode','PLZ');
    $labels['BillingAddressPlace'] = _t(__CLASS__.'.BillingAddressPlace','Stadt');
    $labels['BillingAddressCountry'] = _t(__CLASS__.'.BillingAddressCountry','Land');
    $labels['Phone'] = _t(__CLASS__.'.Phone','Telefon');
    $labels['Fax'] = _t(__CLASS__.'.Fax','Fax');
    $labels['URL'] = _t(__CLASS__.'.URL','Website');
    $labels['Missions'] = _t(__CLASS__.'.Missions','Stellenangebote');
    $labels['Orders'] = _t(__CLASS__.'.Orders','Bestellungen');

    $labels['SocialFacebook'] = _t(__CLASS__.'.SocialFacebook','Facebook');
    $labels['SocialTwitter'] = _t(__CLASS__.'.SocialTwitter','Twitter');
    $labels['SocialInstagram'] = _t(__CLASS__.'.SocialInstagram','Instagram');
    $labels['SocialPinterest'] = _t(__CLASS__.'.SocialPinterest','Pinterest');
    $labels['SocialXing'] = _t(__CLASS__.'.SocialXing','Xing');
    $labels['SocialLinkedin'] = _t(__CLASS__.'.SocialLinkedin','Linkedin');
    $labels['ContactPersonTelephone'] = _t(__CLASS__.'.ContactPersonTelephone','Telefon');
    $labels['ContactPersonMobile'] = _t(__CLASS__.'.ContactPersonMobile','Mobil');
    $labels['ContactPersonEmail'] = _t(__CLASS__.'.ContactPersonEmail','E-Mail');

    $labels['ContactPersonTelephone'] = _t(__CLASS__.'.ContactPersonTelephone','Telefon');
    $labels['Description'] = _t(__CLASS__.'.Description','Firmenpräsentation');
    $labels['ReasonWhy'] = _t('ARBEITGEBER.ReasonWhy', 'Warum sollten Sie bei uns arbeiten?');
    $labels['Nummer'] = _t('ARBEITGEBER.Nummer', 'Kunden-Nr.');

    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if (!$this->Nummer && $this->ID > 0){
            $this->Nummer = $this->generateClientNumber();
        }
        
    }

    public function onAfterWrite()
    {
        if ($this->isChanged('LogoID')){
            $changedFields = $this->getChangedFields();
            $oldPicture = Image::get()->byId($changedFields['LogoID']['before']);
            if ($oldPicture){
                $oldPicture->File->deleteFile();
                DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($oldPicture->ID));
                $oldPicture->delete();
            }
        }
        parent::onAfterWrite();
       
    }

    public function generateClientNumber(){
        $config = SiteConfig::current_site_config();
        return number_format ( $config->ClientNumberOffset.'-'.str_pad($this->ID, 4, '0', STR_PAD_LEFT) , 0 ,  "." ,  "." );
    }   


    public function NiceAddress($full = true){
        $html = '<p>';
        if ($this->Company){
            $html .= $this->Company.'<br/>';
        }
        if ($this->ContactPersonSurname){
            $html .= $this->ContactPersonFirstName.' '.$this->ContactPersonSurname.'<br/>';
        }
        if ($this->Address){
            $html .= $this->Address.'<br/>';
        }
        
        $html .= $this->PostalCode.' - '.$this->City.'</p>';
        if ($full){
            $html .= '<p><a href="mailto:'.$this->CompanyEmail.'">'.$this->CompanyEmail.'</a>'.'<br/>'
        .$this->Telefon.'</p>';
        }
        $o = new DBHTMLText();
        $o->setValue($html);
        return $o;
    }

    public function NiceCountry(){
        return ($this->Country) ? i18n::getData()->getCountries()[$this->Country] : null;
    }

    //Fallback compartiblity
    public function printAddress($full = true){
        return $this->NiceAddress($full);
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();

       $fields->removeByName('BlogPosts');
       $fields->removeByName('Permissions');
       $fields->FieldByName('Root.Main')->setTitle('Kunden Daten');

       return $fields;
    }


    public function generateFolderName(){
        return "Uploads/Arbeitgeber/".$this->ID;
    }

    public function getTitle(){
        $str = $this->Company;
        if( $this->City ){
            $str .= ', '.$this->City;
        }
        return $str;
    }

    public function ContactTitle(){
        $str = '';
        if ($this->ContactPersonFirstName){
            $str .= $this->ContactPersonFirstName.' ';
            if ($this->ContactPersonSurname){
                $str .= $this->ContactPersonSurname;
            }
        }
        else{
            $str .= $this->Member()->FirstName.' '.$this->Member()->Surname;
        }

        return $str;
    }

    public function activeOrderJobOffer(){
        return $this->Orders()->filter('isActive',1)->filterByCallback(function($item, $list) { return $item->Product()->ClassName == Package::class; })->first();
    }

    public function activeOrderMatchingTool(){
        return $this->Orders()->filter('isActive',1)->filterByCallback(function($item, $list) { return $item->Product()->ClassName == MatchingToolPackage::class; })->first();
    }

    public function stagedOrder(){
        return $this->Orders()->filter('isPaid',0)->filterByCallback(function($item, $list) { return $item->Product()->ClassName == Package::class; })->first();
    }

    public function stagedOrderMatchingTool(){
        return $this->Orders()->filter('isPaid',0)->filterByCallback(function($item, $list) { return $item->Product()->ClassName == MatchingToolPackage::class; })->first();
    }

    public function lastMatchQueries(){
        return $this->Queries()->sort('Created','DESC')->limit(10);
    }

    public function Matches(){
        $matches = DataList::create(MatchingResult::class);
        foreach ($this->Queries() as $query) {
            foreach ($query->Results()->filter('isVisible',1) as $match) {
                $matches->add($match);
            }
        }
        return $matches->sort('Created','ASC');
    }


    public function getProfileFields(){
        $fields = FieldList::create(
            HiddenField::create('LogoID','Logo'),
            CompositeField::create(
                HTMLEditorField::create('Description',$this->fieldLabels()['Description'])->setRows(8),
                HTMLEditorField::create('ReasonWhy',$this->fieldLabels()['ReasonWhy'])->setRows(8)
            )->setName('CompanyFields'),
            CompositeField::create(
                HeaderField::create('TitleSocial', _t('ARBEITGEBER.TitleSocial', 'Online Kanäle'), 3), 
                TextField::create('URL', $this->fieldLabels()['URL']), 
                TextField::create('SocialFacebook', $this->fieldLabels()['SocialFacebook']), 
                TextField::create('SocialTwitter', $this->fieldLabels()['SocialTwitter']), 
                TextField::create('SocialInstagram', $this->fieldLabels()['SocialInstagram']), 
                TextField::create('SocialPinterest',$this->fieldLabels()['SocialPinterest']),
                TextField::create('SocialXing', $this->fieldLabels()['SocialXing']), 
                TextField::create('SocialLinkedin',$this->fieldLabels()['SocialLinkedin'])  
            )->setname('OnlineFields'),
            



            HeaderField::create('TitleOffers', _t('ARBEITGEBER.TitleOffers', 'Angebot'), 3)



            // ListboxField::create('Offers', _t('ARBEITGEBER.Offers', 'Was wir bieten'), $Employer->ConfigurationSet()->Offers()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true'), 
            // ListboxField::create('Infrastructure', _t('ARBEITGEBER.Infrastructure', 'Infrastruktur'), $Employer->ConfigurationSet()->Infrastructure()->map('ID','Title__de_DE')->toArray())->setMultiple(true)->setAttribute('data-placeholder', _t('ARBEITGEBER.Choose', 'Bitte wählen'))->setAttribute("data-chosen", 'true'), 
            
        );

        // $fields->replaceField('Country',DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));
        
        return $fields;
    }

    public function getRequiredProfileFields(){
       
        return new RequiredFields(['Company','Address','City','PostalCode','Land']);
    }

    public function getAccountFields(){
        $billingaddresssection = Wrapper::create(
                TextField::create('BillingAddressCompany', _t('ARBEITGEBER.BillingAddressCompany', 'Firma')),
                TextField::create('BillingAddressStreet', _t('ARBEITGEBER.BillingAddressStreet', 'Adresse')),
                TextField::create('BillingAddressPostalCode', _t('ARBEITGEBER.BillingAddressPostalCode', 'PLZ')),
                TextField::create('BillingAddressPlace', _t('ARBEITGEBER.BillingAddressPlace', 'Ort')),
                DropdownField::create('BillingAddressCountry',$this->fieldLabels()['BillingAddressCountry'])->setSource(i18n::getData()->getCountries())->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen'))->setValue('de')
            )->addExtraClass('uk-margin-top')
            ->hideIf("BillingAddressIsCompanyAddress")->isChecked()->end();


            $fields = new FieldList(
                HeaderField::create('AdressTitle', _t('ARBEITGEBER.AdressTitle', 'Firmenadresse'), 3),
                TextField::create('Company', _t('ARBEITGEBER.Company', 'Firma')),
                TextField::create('Address', _t('ARBEITGEBER.AddressStreet', 'Adresse')),
                TextField::create('PostalCode', _t('ARBEITGEBER.AddressPostalCode', 'PLZ')),
                TextField::create('City', _t('ARBEITGEBER.AddressPlace', 'Ort')),
                DropdownField::create('Country',$this->fieldLabels()['Country'])->setSource(i18n::getData()->getCountries())->setValue('de')->setAttribute('class','uk-select')->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')),

                TextField::create('CompanyEmail', _t('ARBEITGEBER.Email', 'E-Mail')),
                TextField::create('Phone', _t('ARBEITGEBER.Telephone', 'Telefon')),
                // TextField::create('Cipher', _t('ARBEITGEBER.Cipher', 'Chiffre')),
                HeaderField::create('BillingAdressTitle', _t('ARBEITGEBER.BillingAdressTitle', 'Rechnungsadresse'), 3),
                CheckboxField::create('BillingAddressIsCompanyAddress', _t('ARBEITGEBER.BillingAddressIsCompanyAddress', 'Rechnungsadresse ist Firmenadresse'))->setAttribute('class','uk-checkbox'),
                $billingaddresssection,
                HeaderField::create('ContactPersonTitle', _t('ARBEITGEBER.ContactPersonTitle', 'Ansprechparter'), 3),
                TextField::create('ContactPersonFirstName', _t('ARBEITGEBER.ContactPersonFirstName', 'Vorname')),
                TextField::create('ContactPersonSurname', _t('ARBEITGEBER.ContactPersonSurname', 'Nachname')),
                TextField::create('ContactPersonTelephone', _t('ARBEITGEBER.ContactPersonTelephone', 'Telefon')),
                TextField::create('ContactPersonMobile', _t('ARBEITGEBER.ContactPersonMobile', 'Mobil'))
            );

        return $fields;
    }

    public function getRequiredAccountFields(){
       
        return new RequiredFields(['AdressTitle','Company','Address','PostalCode','City','Country','Phone','CompanyEmail','ContactPersonFirstName','ContactPersonSurname']);
    }


    public function getCandidatures(){
        $ids = $this->Missions()->column('ID');
        if ($ids){
            return Candidature::get()->filter('MissionID',$ids)->exclude('Status','deleted')->sort(['Status' => 'ASC', 'Created' => 'DESC']);
        }
        return null;
    }

}