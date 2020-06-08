<?php
namespace Deskall\SEO;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Config\Config;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Manifest\ModuleLoader;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\i18n\i18n;
use SilverStripe\Control\Director;
use SilverStripe\View\SSViewer;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;

class SEOPageExtension extends DataExtension
{
    private static $db = [
    'MetaTitle' => 'Varchar(255)',
    'ExtraMeta' => 'HTMLText'   
	];

    private static $has_one = ['SharableImage' => Image::class];

    private static $owns = ['SharableImage'];

    public function onBeforeWrite(){
    	parent::onBeforeWrite();
    	if (!$this->owner->isChanged('MetaTitle',2)){
    		$this->owner->MetaTitle = strip_tags($this->owner->Title);
    	}
    }
    
	public function updateFieldLabels(&$labels) {
		$labels['MetaTitle'] = _t('SiteTree.METATITLE', "MetaTitel");
	}

    public function updateCMSFields(FieldList $fields){
    	$toExclude = Config::inst()->get("Deskall\SEO\SeoObjectExtension", "excluded_page_types");
		if (is_array($toExclude) && in_array($this->owner->getClassName(), $toExclude)) {
			return;
		}

		$fields->addFieldToTab('Root.SEO',UploadField::create("SharableImage",_t('SEO.PREVIEWImage','Vorschau Bild für Share'))->setFolderName($this->owner->generateFolderName()));

		Requirements::css('deskall-seo/css/seo.css');
		Requirements::javascript('deskall-seo/javascript/seo.js');

		$fields->addFieldsToTab('Root.SEO', array(
			LiteralField::create('googlesearchsnippetintro', '<h3>' . _t('SEO.SEOGoogleSearchPreviewTitle', 'Googlesuche Vorschau') . '</h3>'),
			LiteralField::create('googlesearchsnippet', '<div id="google_search_snippet"></div>'),
			LiteralField::create('siteconfigtitle', '<div id="ss_siteconfig_title">' . $this->owner->getSiteConfig()->Title . '</div>'),
		));


		$fields->removeFieldFromTab('Root.Main', 'Metadata');


		$fields->addFieldsToTab('Root.SEO', array(
			TextField::create("MetaTitle", $this->owner->fieldLabel('MetaTitle'))
				->setDescription(
					_t(
						'SiteTree.METATITLEHELP',
						'Shown at the top of the browser window and used as the "linked text" by search engines.'
					)
				)
				->addExtraClass('help'),
			TextareaField::create("MetaDescription", $this->owner->fieldLabel('MetaDescription'))
				->setDescription(
					_t(
						'SiteTree.METADESCHELP',
						"Suchmaschinen verwenden diesen Inhalt zur Anzeige von Suchergebnissen (obwohl dies keinen Einfluss auf ihr Ranking hat)."
					)
				)
				->addExtraClass('help'),
			TextareaField::create("ExtraMeta",$this->owner->fieldLabel('ExtraMeta'))
				->setDescription(
					_t(
						'SiteTree.METAEXTRAHELP', 
						"HTML tags für weitere MetaInformation. Zum Beispiel &lt;meta name=\"customName\" content=\"Ihr custom Inhalt hier\" /&gt;"
					)
				)
				->addExtraClass('help')
			
			)
		);
    }

    public function onBeforeWrite(){
    	parent::onBeforeWrite();
    	if (!$this->owner->isChanged('MetaTitle',2)){
    		$this->owner->MetaTitle = strip_tags($this->owner->Title);
    	}
    }

    /* MetaTags
	*  Hooks into MetaTags SiteTree method and adds MetaTags for
	*  Sharing of this page on Social Media (Facebook / Google+)
	*/
	public function MetaTags(&$tags) {

		$siteConfig = SiteConfig::current_site_config();
		if(!$this->owner->MetaDescription){
			$tags .= '<meta name="description" content="'.$this->owner->PrintDescription().'" />' . "\n";
		}
		
		// facebook OpenGraph
		$tags .= '<meta property="og:type" content="website" />' . "\n";
		$tags .= '<meta property="og:url" content=" ' . Director::AbsoluteUrl($this->owner->Link()). ' " />' . "\n";
		$tags .= '<meta property="og:title" content="' . $this->owner->Title . '" />' . "\n";
		$tags .= '<meta property="og:description" content="' . $this->owner->PrintDescription() . '" />' . "\n";
		if ($this->owner->OpenGraphImage()){
			$tags .= '<meta property="og:image:width" content="600" />' . "\n";
			$tags .= '<meta property="og:image:height" content="315" />' . "\n";
			$tags .= '<meta property="og:image" content="'.Director::absoluteBaseURL().ltrim($this->owner->OpenGraphImage(),"/").'" />' . "\n";
		}
		$tags .= '<meta property="og:locale" content="' . i18n::get_locale() . '" />' . "\n";
		$tags .= '<meta property="og:site_name" content="' . $siteConfig->Title . '" />' . "\n";
		
		

		//Twitter meta Card
		$tags .= '<meta name="twitter:card" content="summary" />'. "\n";
		$tags .= '<meta name="twitter:site" content="'.Director::AbsoluteUrl($this->owner->Link()).'" />'. "\n";
		$tags .= '<meta name="twitter:title" content="' . $this->owner->Title . '" />'. "\n";
		$tags .= '<meta name="twitter:description" content="' . $this->owner->PrintDescription() . '" />';
		if ($this->owner->OpenGraphImage()){
			$tags .=  '<meta name="twitter:image" content="'.Director::absoluteBaseURL().ltrim($this->owner->OpenGraphImage(),"/").'" />';
		}
        $tags .= $siteConfig->GoogleWebmasterMetaTag . "\n";
	}

	/* Google Structured data
	*  provide json-d formated data for google sharing and snippet
	* @return json-d
	*/
	public function StructuredData() {

		$siteConfig = SiteConfig::current_site_config();
		$sd = '<script type="application/ld+json">
		{
			"@context": "http://schema.org",
			"@type": "WebPage",
			"url": "'.rtrim(Director::AbsoluteUrl($this->owner->Link()),'/').'",
			"description": "'.$this->owner->PrintDescription().'"';

		if ($this->owner->OpenGraphImage()){
			$sd .= ',"image": "'.Director::absoluteBaseURL().ltrim($this->owner->OpenGraphImage(),"/");
		}

		$sd .= "\n".'}
		</script>';

		return DBField::create_field('HTMLText',$sd);
	}


	public function getStructuredBreadcrumbs(){

	  $pages = $this->owner->getBreadcrumbItems();
	  $array = [];
	  $i = 1;
	  foreach ($pages as $page) {
	    $array[] = ["@type" => "ListItem", "position" => $i,"item" => ["@id" => Director::AbsoluteURL($page->Link()), "name" => $page->Title, "@type" => "WebPage"]];
	    $i++;
	  }

	  $html = '<script type="application/ld+json">
	  {
	    "@context": "http://www.schema.org",
	    "@type": "BreadcrumbList",
	    "itemListElement": '.json_encode($array).'
	  }
	  </script>';
	   return DBField::create_field('HTMLText',$html);

	}

	public function PrintDescription(){
		if ($this->owner->MetaDescription != ""){
			return $this->owner->MetaDescription;
		}
		$content = '';
		foreach ($this->owner->ElementalArea()->Elements()->filter('isVisible',1) as $block) {
			if ($block->HTML){
				$content .= $block->HTML;
			}
			if ($block->Content){
				$content .= $block->content;
			}
		}
		$content = trim(str_replace("\n"," ",strip_tags($content)));

		return DBField::create_field('HTMLText',$content)->LimitWordCount(60);
	}


	/**
	* Return page image url to display on Facebook or Google +
	* @return string
	* By default Page Open Graph > Site Default Open graph
	*/
	public function OpenGraphImage(){
		if ($this->owner->SharableImageID > 0){
			return $this->owner->SharableImage()->FocusFill(600,315)->URL;
		}
		$siteConfig = SiteConfig::current_site_config();
		return ($siteConfig->OpenGraphDefaultImage()->exists() ) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,315)->URL : null;
	}
}
