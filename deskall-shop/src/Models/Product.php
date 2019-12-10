<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Bummzack\SortableFile\Forms\SortableUploadField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Control\Director;
use SilverStripe\i18n\i18n;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\RequiredFields;

class Product extends DataObject{

    private static $singular_name = 'Produkt';

    private static $plural_name = 'Produkte';

    private static $db = [
        'Title' => 'Varchar',
        'Subtitle' => 'Text',
        'MenuTitle' => 'Varchar',
        'LeadText' => 'HTMLText',
        'URLSegment' => 'Varchar',
        'Content' => 'HTMLText',
        'Price' => 'Currency',
        'DiscountPrice' => 'Currency',
        'DiscountUntil' => 'Date',
        'Quantities' => 'Int',
        'CanBuyMoreThanOne' => 'Boolean(0)',
        'Footer' => 'HTMLText',
        'Online' => 'Boolean(0)',
        'WithCertification' => 'Boolean(0)',
        'CertificatTitle' => 'Text',
        'CertificatLabel' => 'HTMLText',
        'CertificatDescription' => 'HTMLText',
        'CertificatNotice'  => 'HTMLText',
        'DeliveryTime' => 'Varchar',
        'InStock' => 'Boolean',
        'OutStock' => 'Boolean',
    ];

    private static $has_one = [
    	'Category' => ProductCategory::class,
        'MainImage' => Image::class,
        'ProductFile' => File::class
    ];

    private static $has_many = [
    	'Orders' => Order::class
    ];

    private static $many_many = [
        'Files' => File::class,
        'Images' => Image::class,
        'Features' => ProductFeature::class
    ];

    private static $many_many_extraFields = [
        'Images' => ['SortOrder' => 'Int'],
        'Files' => ['SortOrder' => 'Int']
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    private static $owns = [
        'Files','Images','ProductFile'
    ];

    public function canView($member = null) {
        return true;
    }


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Subtitle'] = _t(__CLASS__.'.Subtitle','SubTitel');
        $labels['MenuTitle'] = _t(__CLASS__.'.MenuTitle','Menu');
        $labels['LeadText'] = _t(__CLASS__.'.LeadText','Einstiegtext');
        $labels['Content'] = _t(__CLASS__.'.Content','Produkt Inhalte');
        $labels['Price'] = _t(__CLASS__.'.Price','Preis');
        $labels['DiscountPrice'] = _t(__CLASS__.'.DiscountPrice','Aktion Preis');
        $labels['DiscountUntil'] = _t(__CLASS__.'.DiscountUntil','Aktion bis');
        $labels['Quantities'] = _t(__CLASS__.'.Quantities','Anzahl');
        $labels['Footer'] = _t(__CLASS__.'.Footer','Footer');
        $labels['Files'] = _t(__CLASS__.'.Files','Dateien');
        $labels['Images'] = _t(__CLASS__.'.Images','Bilder');
        $labels['Orders'] = _t(__CLASS__.'.Orders','Bestellungen');
        $labels['Online'] = _t(__CLASS__.'.Online','nur Online verfügbar?');
        $labels['WithCertification'] = _t(__CLASS__.'.WithCertification','mit Zertifikat?');
        $labels['CanBuyMoreThanOne'] = _t(__CLASS__.'.CanBuyMoreThanOne','kann in mehreren Exemplaren erworben werden?');
        $labels['CertificatTitle'] = _t(__CLASS__.'.CertificatTitle','Titel des Zertifikats');
        $labels['CertificatNotice'] = _t(__CLASS__.'.CertificatNotice','Hinweis');
        $labels['CertificatDescription'] = _t(__CLASS__.'.CertificatDescription','Beschreibung des Zertifikats');
        $labels['CertificatLabel'] = _t(__CLASS__.'.CertificatLabel','Label des Zertifikats');
        $labels['DeliveryTime'] = _t(__CLASS__.'.DeliveryTime','Lieferzeit');
        $labels['InStock'] = _t(__CLASS__.'.inStock','im Stock');
        $labels['OutStock'] = _t(__CLASS__.'.outStock','Ausverkauft');

        return $labels;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->MenuTitle);
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('URLSegment');
        $fields->removeByName('Files');
        $fields->removeByName('Images');
        $fields->removeByName('Orders');
        $fields->removeByName('CategoryID');

        $fields->addFieldsToTab('Root.Files',[
            $fields->fieldByName('Root.Main.MainImage'),
            $fields->fieldByName('Root.Main.ProductFile'),
        	SortableUploadField::create('Files',$this->fieldLabels()['Files'])->setIsMultiUpload(true)->setFolderName($this->getFolderName()),
        	SortableUploadField::create('Images',$this->fieldLabels()['Images'])->setIsMultiUpload(true)->setFolderName($this->getFolderName())
        ]);

		$fields->fieldByName('Root.Files')->setTitle('Datei');
        $fields->fieldByName('Root.Main.WithCertification')->displayIf('Online')->isChecked()->end();
        $fields->fieldByName('Root.Main.CertificatTitle')->displayIf('WithCertification')->isChecked()->end();
        $fields->fieldByName('Root.Main.CertificatLabel')->setRows(3)->displayIf('WithCertification')->isChecked()->end();
        $fields->fieldByName('Root.Main.CertificatDescription')->setRows(3)->displayIf('WithCertification')->isChecked()->end();
        $fields->fieldByName('Root.Main.CertificatNotice')->setRows(3)->displayIf('WithCertification')->isChecked()->end();

        $fields->fieldByName('Root.Main.DeliveryTime')->displayIf('Online')->isNotChecked()->end();
        $fields->fieldByName('Root.Main.InStock')->displayIf('Online')->isNotChecked()->end();
        $fields->fieldByName('Root.Main.OutStock')->displayIf('Online')->isNotChecked()->end();

        // $orderconfig = GridFieldConfig_RecordEditor::create();
        // $orderconfig->addComponent(new GridFieldOrderableRows('Sort'));
        // $orderconfig->addComponent(new GridFieldShowHideAction());
        // $orderconfig->addComponent(new GridFieldDuplicateAction());
        // $ordersField = new GridField('Orders',_t(__CLASS__.'.Orders','Bestellungen'),$this->Orders(),$orderconfig);
        // $fields->addFieldToTab('Root.Orders',$ordersField);
        // $fields->fieldByName('Root.Orders')->setTitle('Bestellungen');
        
        return $fields;
    }

    public function getCMSValidator(){
        return new RequiredFields(
        'Title',
        'MenuTitle',
        'LeadText',
        'Price'
        );
    }

    public function CloseProducts(){
        return Product::get()->filter(['isVisible' => 1,'CategoryID' => $this->CategoryID])->exclude('ID',$this->ID);
    }


    public function getFolderName(){
        return "Uploads/Produkte/".$this->URLSegment;
    }

    public function Link(){
        return 'shop/produkte/'.$this->URLSegment.'/';
    }

    public function AbsoluteLink() {
        return str_replace('www.','',Director::absoluteURL($this->Link()));
    }

    public function BuyLink(){
        return 'shop/kaufen/'.$this->URLSegment.'/';
    }


    public function MetaTags(){
        $tags = '';
        $siteConfig = SiteConfig::current_site_config();
        
        //Metatags
        $tags .= '<meta name="description" content="'.strip_tags($this->LeadText).'">';

        // facebook OpenGraph
        $tags .= '<meta property="og:type" content="product" />' . "\n";
        $tags .= '<meta property="og:title" content="' . $this->Title . '" />' . "\n";
        $tags .= '<meta property="og:description" content="' . strip_tags($this->LeadText) . '" />' . "\n";
        $tags .= '<meta property="og:url" content=" ' .Director::AbsoluteUrl($this->Link()). ' " />' . "\n";
        $tags .= '<meta property="product:price:amount" content="' . $this->Price . '" />' . "\n";
        $tags .= '<meta property="product:price:currency" content="EUR" />' . "\n";
        $imageurl = ($this->MainImage()->exists()) ? $this->MainImage()->Link() : (($this->Images()->first()) ? $this->Images()->first()->FocusFill(600,300)->getURL() : ( ($siteConfig->OpenGraphDefaultImage()->exists()) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,300)->getURL() : null));
        if ($imageurl){
            $tags .= '<meta property="og:image:width" content="600" />' . "\n";
            $tags .= '<meta property="og:image:height" content="300" />' . "\n";
            $tags .= '<meta property="og:image" content="'.Director::absoluteBaseURL().ltrim( $imageurl,"/").'" />' . "\n";
        }
        $tags .= '<meta property="og:locale" content="' . i18n::get_locale() . '" />' . "\n";
        $tags .= '<meta property="og:site_name" content="' . $siteConfig->Title . '" />' . "\n";
       
    
        //Twitter meta Card
        $tags .= '<meta name="twitter:card" content="summary" />'. "\n";
        $tags .= '<meta name="twitter:site" content="'.Director::AbsoluteUrl($this->Link()).'" />'. "\n";
        $tags .= '<meta name="twitter:title" content="' . $this->Title . '" />'. "\n";
        $tags .= '<meta name="twitter:description" content="' . strip_tags($this->LeadText) . '" />';
        if ($imageurl){
            $tags .=  '<meta name="twitter:image" content="'.Director::absoluteBaseURL().ltrim( $imageurl,"/").'" />';
        }
        $tags .= $siteConfig->GoogleWebmasterMetaTag . "\n";

        return DBField::create_field('HTMLText',$tags);
    }

    public function StructuredData(){
        $html = '<script type="application/ld+json">
        {
          "@context": "http://schema.org",
          "@type": "Product",
          "name": "'.$this->Title.'",
          "description": "'.strip_tags($this->LeadText).'",
          "offers": {
            "@type": "Offer",
            "availability": "http://schema.org/InStock",
            "price": "'.$this->Price.'",
            "priceCurrency": "EUR"
          },
          "provider": {
            "@type": "Organization",
            "name": "Schneider Hotelgastro Consulting",
            "sameAs": "'.Director::AbsoluteBaseURL().'"
          }
        }
        </script>';

        return DBField::create_field('HTMLText',$html);
    }

    public function currentPrice(){
        if ($this->DiscountPrice > 0 && (!$this->DiscountUntil || $this->DiscountUntil > date('Y-m-d'))){
            return $this->DiscountPrice;
        }
        return $this->Price;
    }

    public function getProductConfig(){
        return ProductConfig::get()->first();
    }

}
