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

class SEOPageExtension extends DataExtension
{
    private static $db = [
    'MetaTitle' => 'Varchar(255)',
    'ExtraMeta' => 'HTMLText',
    'ExtraScript' => 'HTMLText'
    ];

    private static $has_one = ['SharableImage' => Image::class];

    private static $owns = ['SharableImage'];


	public function updateFieldLabels(&$labels) {
		$labels['MetaTitle'] = _t('SiteTree.METATITLE', "MetaTitel");
	}

    public function updateCMSFields(FieldList $fields){
    	$toExclude = Config::inst()->get("Deskall\SEO\SeoObjectExtension", "excluded_page_types");
		if (is_array($toExclude) && in_array($this->owner->getClassName(), $toExclude)) {
			return;
		}

		$fields->addFieldToTab('Root.SEO',UploadField::create("SharableImage",'Vorschau Bild für Shares')->setFolderName($this->owner->generateFolderName()));

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
				->addExtraClass('help'),
			TextareaField::create("ExtraScript","Extra Script für diese Seite")
				->setDescription(
					_t(
						'SiteTree.METAEXTRASCRIPTHELP', 
						"Füngen Sie spezialle Script-Tags hier ein, zb Facebook oder Google Tracking Scripts."
					)
				)
				->addExtraClass('help')
			)
		);
    }

    /* MetaTags
	*  Hooks into MetaTags SiteTree method and adds MetaTags for
	*  Sharing of this page on Social Media (Facebook / Google+)
	*/
	public function MetaTags(&$tags) {

		$siteConfig = SiteConfig::current_site_config();
		
		// facebook OpenGraph
		
		$tags .= '<meta property="og:locale" content="' . i18n::get_locale() . '" />' . "\n";
		$tags .= '<meta property="og:title" content="' . $this->owner->Title . '" />' . "\n";
		$tags .= '<meta property="og:description" content="' . $this->owner->MetaDescription . '" />' . "\n";
		$tags .= '<meta property="og:url" content=" ' . rtrim(Director::AbsoluteUrl($this->owner->Link()),'/'). ' " />' . "\n";
		$tags .= '<meta property="og:site_name" content="' . $siteConfig->Title . '" />' . "\n";
		$tags .= '<meta property="og:type" content="website" />' . "\n";
		if ($this->owner->OpenGraphImage()){
			$tags .= '<meta property="og:image:width" content="600" />' . "\n";
			$tags .= '<meta property="og:image:height" content="300" />' . "\n";
			$tags .= '<meta property="og:image" content="'.Director::absoluteBaseURL().ltrim($this->owner->OpenGraphImage(),"/").'" />' . "\n";
		}
        $tags .= $siteConfig->GoogleWebmasterMetaTag . "\n";
	}

	/* Google Structured data
	*  provide json-d formated data for google sharing and snippet
	* @return json-d
	*/
	public function StructuredData() {

		$siteConfig = SiteConfig::current_site_config();
		$sd = '<script type="application/ld+json">';
		$sd .= '{"@context": "http://schema.org",' . "\n";
		$sd .= '"@type": "WebPage",' . "\n";
		$sd .= '"url": "'.rtrim(Director::AbsoluteUrl($this->owner->Link()),'/').'",' . "\n";
		$sd .= '"description": "'.$this->owner->MetaDescription.'",' . "\n";
		if ($this->owner->OpenGraphImage()){
			$sd .= '"image": "'.Director::absoluteBaseURL().ltrim($this->owner->OpenGraphImage(),"/").'"'. "\n";
		}
		
		$sd .= '}'. "\n";
		$sd .= '</script>';

		return $sd;
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
		return ($siteConfig->OpenGraphDefaultImageID > 0) ? $siteConfig->OpenGraphDefaultImage()->FocusFill(600,315)->URL : null;
	}
}
