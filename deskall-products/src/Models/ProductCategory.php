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
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\i18n\i18n;
use SilverStripe\Control\Director;

class ProductCategory extends DataObject{


    private static $db = [
        'Title' => 'Varchar',
        'Subtitle' => 'Text',
        'MenuTitle' => 'Varchar',
        'LeadText' => 'HTMLText',
        'URLSegment' => 'Varchar'
    ];

    private static $has_one = [
        'Parent' => ProductCategory::class
    ];

    private static $has_many = [
        'Products' => Product::class,
        'SubCategories' => ProductCategory::class
    ];

    private static $extensions = [
        'Activable',
        'Sortable'
    ];


    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Title'] = _t(__CLASS__.'.Title','Titel');
        $labels['Subtitle'] = _t(__CLASS__.'.Subtitle','SubTitel');
        $labels['MenuTitle'] = _t(__CLASS__.'.MenuTitle','Menu');
        $labels['LeadText'] = _t(__CLASS__.'.LeadText','Einstiegtext');
     
        return $labels;
    }

    public function canView($member = null) {
        return true;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->removeByName('URLSegment');
        
        return $fields;
    }

    public function getCMSValidator(){
        return new RequiredFields(
        'Title',
        'MenuTitle'
        );
    }

     public function onBeforeWrite(){
        parent::onBeforeWrite();
        $this->URLSegment = URLSegmentFilter::create()->filter($this->MenuTitle);
    }

    public function Link(){
        return 'shop/kategorien/'.$this->URLSegment;
    }

    public function AbsoluteLink() {
        return str_replace('www.','',Director::absoluteURL($this->Link()));
    }

    public function activeProducts(){
        return $this->Products()->filter('isVisible',1);
    }

    public function activeCategories(){
        return $this->SubCategories()->filter('isVisible',1);
    }

    public function getBreadCrumbs(){
        $html = '<span class="uk-text-muted">'.$this->MenuTitle.'</span>';
        if ($this->Parent()->exists()){
            $parent = $this->Parent();
            while($parent->exists()){
                $html = '<a href="'.$parent->Link().'" title="'.$parent->Title.'">'.$parent->MenuTitle.'</a> » '.$html;
                $parent = $parent->Parent();
            }
        }

        return DBField::create_field('HTMLText',$html);
    }

    public function MetaTags(){
        $tags = '';
        $siteConfig = SiteConfig::current_site_config();
        
        //Metatags
        $tags .= '<meta name="description" content="'.strip_tags($this->LeadText).'">';

        // facebook OpenGraph
        $tags .= '<meta property="og:type" content="website" />' . "\n";
        $tags .= '<meta property="og:title" content="' . $this->Title . '" />' . "\n";
        $tags .= '<meta property="og:description" content="' . strip_tags($this->LeadText) . '" />' . "\n";
        $tags .= '<meta property="og:url" content=" ' .Director::AbsoluteUrl($this->Link()). ' " />' . "\n";
       
        $tags .= '<meta property="og:locale" content="' . i18n::get_locale() . '" />' . "\n";
        $tags .= '<meta property="og:site_name" content="' . $siteConfig->Title . '" />' . "\n";
       
    
        //Twitter meta Card
        $tags .= '<meta name="twitter:card" content="summary" />'. "\n";
        $tags .= '<meta name="twitter:site" content="'.Director::AbsoluteUrl($this->Link()).'" />'. "\n";
        $tags .= '<meta name="twitter:title" content="' . $this->Title . '" />'. "\n";
        $tags .= '<meta name="twitter:description" content="' . strip_tags($this->LeadText) . '" />';
        
        $tags .= $siteConfig->GoogleWebmasterMetaTag . "\n";

        return DBField::create_field('HTMLText',$tags);
    }

    public function StructuredData(){
        $sd = '<script type="application/ld+json">
        {
            "@context": "http://schema.org",
            "@type": "WebPage",
            "url": "'.rtrim(Director::AbsoluteUrl($this->Link()),'/').'",
            "description": "'.strip_tags($this->LeadText).'"';

        if ($this->OpenGraphImage()){
            $sd .= ','."\n".'"image": "'.Director::absoluteBaseURL().ltrim($this->OpenGraphImage(),"/");
        }

        $sd .= "\n".'}
        </script>';

        return DBField::create_field('HTMLText',$sd);
    }


    public function OpenGraphImage(){
        $siteConfig = SiteConfig::current_site_config();
        return ($siteConfig->OpenGraphDefaultImage()->exists() ) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,315)->URL : null;
    }

}
