<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Control\Director;
use SilverStripe\i18n\i18n;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBCurrency;

class EventDate extends DataObject{

    private static $singular_name = 'Termin';

    private static $plural_name = 'Termine';

    private static $db = [
        'Date' => 'Varchar',
        'Place' => 'Text',
        'Address' => 'Varchar',
        'Code' => 'Varchar',
        'City' => 'Varchar',
        'Country' => 'Varchar',
        'Places' => 'Int',
        'isOpen' => 'Boolean(0)',
        'isFull' => 'Boolean(0)',
        'Closed' => 'Boolean(0)',
        'Price' => 'Currency',
        'Start' => 'Datetime',
        'End' => 'Datetime'
    ];

    private static $has_one = [
    	'Event' => Event::class
    ];

    private static $has_many = [
        'Orders' => EventOrder::class
    ];

    private static $many_many = [
        'Participants' => Participant::class
    ];

    private static $many_many_extraFields = [
        'Participants' => ['paid' => 'Boolean(0)']
    ];


    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    private static $summary_fields = [
        'Date',
        'City',
        'Price',
        'Places',
        'Participants.count' => ['title' => 'Teilnehmer'],
        'ConfirmedParticipants' => ['title' => 'Teilnehmer (bezahlt)']
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Date'] = _t(__CLASS__.'.Date','Datum');
        $labels['Place'] = _t(__CLASS__.'.Place','Ort');
        $labels['Address'] = _t(__CLASS__.'.Address','Adresse');
        $labels['Code'] = _t(__CLASS__.'.Code','PLZ');
        $labels['City'] = _t(__CLASS__.'.City','Stadt');
        $labels['Country'] = _t(__CLASS__.'.Country','Land');
        $labels['Places'] = _t(__CLASS__.'.Places','Plätze zur Verfügung');
        $labels['isOpen'] = _t(__CLASS__.'.isOpen','ist Anmeldung möglich?');
        $labels['isFull'] = _t(__CLASS__.'.isFull','ist ausgebucht?');
        $labels['Closed'] = _t(__CLASS__.'.Closed','ist geschlossen?');
        $labels['Price'] = _t(__CLASS__.'.Price','Preis');
        $labels['Main'] = _t(__CLASS__.'.Main','Haupt');
        $labels['Orders'] = _t(__CLASS__.'.Participants','Teilnehmer');
        $labels['Start'] = _t(__CLASS__.'.Start','Von');
        $labels['End'] = _t(__CLASS__.'.end','Bis');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Participants');
        $fields->removeByName('Date');
        $fields->removeByName('Country');
        $fields->FieldByName('Root.Main')->setTitle('Termin Angaben');
        if ($this->ID > 0){
            $fields->FieldByName('Root.Orders.Orders')->getConfig()
            ->removeComponentsByType([
                GridFieldEditButton::class,
                GridFieldAddNewButton::class,
                GridFieldAddExistingAutocompleter::class
            ])
            ->addComponent(new GridFieldDeleteAction())->addComponent(new GridFieldPaidAction());
        }
        

        $fields->insertAfter('City',DropdownField::create('Country',$this->fieldLabels(false)['Country'])->setSource(i18n::getData()->getCountries())->setEmptyString(_t(__CLASS__.'.CountryLabel','Land wählen')));
        // $grid = $fields->FieldByName('Root.Participants.Participants');
        // $config = $grid->getConfig();
        // $columns = $config->getComponentByType(GridFieldDataColumns::class)->setDisplayFields([
        //     'Title' => ['title' => 'Name'],
        //     'printAddress' => ['title' => 'Adresse'],
        //     'paid' => ['title' => 'Bezahlt?']
        // ]);
        return $fields;
    }

    public function getCMSValidator(){
        return new RequiredFields(
        'Place',
        'Address',
        'Code',
        'City',
        'Country',
        'Price',
        'Start',
        'End');
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        
            $start = new \DateTime($this->Start);
            $end = new \DateTime($this->End);
            if ($start->format('d.m.Y') != $end->format('d.m.Y')){
                $this->Date = 'von '.$start->format('d.m.Y H:i').' bis '.$end->format('d.m.Y H:i');
            }
            else{
                $this->Date = $start->format('d.m.Y H:i').' - '.$end->format('H:i').' Uhr';
            } 
            if ($this->Places == 0){
                $this->isFull = true;
            }  
    }

    public function MwSt(){
        $mwst = $this->Price * floatval(SiteConfig::current_site_config()->MwSt) / 100;
        return DBCurrency::create()->setValue($mwst);
    }

    public function getEventConfig(){
        return EventConfig::get()->last();
    }

    public function HeaderSlide(){
        return $this->Event()->HeaderSlide();
    }

    public function isClose(){
        $past = DateTime::create($this->Start) > new DateTime();
        if ($past){
            $this->Closed = true;
            $this->write();
        }
        return $past;
    }


    public function getConfirmedParticipants(){
        $num = $this->Participants()->filter('paid',1)->count();
        return DBField::create_field('Int',$num);
    }

    public function RegisterLink(){
        return $this->getEventConfig()->MainPage()->Link().'anmeldung/'.$this->Event()->URLSegment.'/'.$this->ID;
    }


    public function EventDateMetaTags(){
        $tags = '';
        $siteConfig = SiteConfig::current_site_config();
        
        //Metatags
        $tags .= '<meta name="description" content="'.strip_tags($this->LeadText).'">';

        // facebook OpenGraph
        $tags .= '<meta property="og:locale" content="' . i18n::get_locale() . '" />' . "\n";
        $tags .= '<meta property="og:title" content="' . $this->Title . '" />' . "\n";
        $tags .= '<meta property="og:description" content="' . strip_tags($this->LeadText) . '" />' . "\n";
        $tags .= '<meta property="og:url" content=" ' . rtrim(Director::AbsoluteUrl($this->Link()),'/'). ' " />' . "\n";
        $tags .= '<meta property="og:site_name" content="' . $siteConfig->Title . '" />' . "\n";
        $tags .= '<meta property="og:type" content="website" />' . "\n";
        
        $imageurl = ($this->Images()->first()) ? $this->Images()->first()->FocusFill(600,300)->getURL() : ( ($siteConfig->OpenGraphDefaultImage()->exists()) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,300)->getURL() : null);
        if ($imageurl){
            $tags .= '<meta property="og:image:width" content="600" />' . "\n";
            $tags .= '<meta property="og:image:height" content="300" />' . "\n";
            $tags .= '<meta property="og:image" content="'.Director::absoluteBaseURL().ltrim( $imageurl,"/").'" />' . "\n";
        }
        $tags .= $siteConfig->GoogleWebmasterMetaTag . "\n";

        return DBField::create_field('HTMLText',$tags);
    }

    public function EventDateStructuredData(){
        $siteConfig = SiteConfig::current_site_config();
        $imageurl = ($this->Event()->Images()->first()) ? $this->Event()->Images()->first()->FocusFill(600,300)->getURL() : ( ($siteConfig->OpenGraphDefaultImage()->exists()) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,300)->getURL() : null);
        $html = '<script type="application/ld+json">{
              "@context": "http://www.schema.org",
              "@type": "Event",
              "startDate": "'.$this->Start.'",
              "endDate": "'.$this->End.'",
              "image": "'.$imageurl.'",
              "name": "'.$this->Event()->Title.'",
              "description": "Informationsanlass zum Seminar \"'.$this->Event()->Title.'\"",
              "location": {
                "@type": "Place",
                "name": "'.$this->Place.'",
                "address": {
                  "@context": "http://www.schema.org",
                  "@type": "PostalAddress",
                  "addressCountry": "'.strtoupper($this->Country).'",
                  "addressLocality": "'.$this->City.'",
                  "postalCode": "'.$this->Code.'",
                  "name": "'.$this->Place.'",
                  "streetAddress": "'.$this->Address.'"
                }
              },
              "offers": {
                "@type": "Offer",
                "price": "'.$this->Price.'",
                "priceCurrency": "EUR",
                "validFrom": "'.DBField::create_field('Date',$this->Created)->format('Y-MM-dd')   .'",
                "url": "'.Director::AbsoluteUrl($this->RegisterLink()).'",
                "availability": "http://schema.org/InStock"
              },
              "performer": {
                "@context": "http://www.schema.org",
                "@type": "Organization",
                "name": "Schneider Hotelgastro Consulting",
                "url": "'.Director::AbsoluteBaseUrl().'",
                "logo": "'.Director::AbsoluteUrl('themes/consulting/img/logo.png').'",
                "address": {
                  "@context": "http://www.schema.org",
                  "@type": "PostalAddress",
                  "addressCountry": "'.strtoupper($siteConfig->Country).'",
                  "addressLocality": "'.$siteConfig->City.'",
                  "postalCode": "'.$siteConfig->Code.'",
                  "name": "'.$siteConfig->AddressTitle.'",
                  "streetAddress": "'.$siteConfig->Address.'"
                },
                "contactPoint": {
                  "@type": "ContactPoint",
                  "telephone": "'.$siteConfig->Phone.'",
                  "contactType": "customer support",
                  "areaServed": "'.strtoupper($siteConfig->Country).'"
                }
              }
            }</script>';

        return DBField::create_field('HTMLText',$html);
    }


    
}
