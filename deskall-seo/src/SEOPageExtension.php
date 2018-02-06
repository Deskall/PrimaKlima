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

class SEOPageExtension extends DataExtension
{
    private static $db = [
    'MetaTitle' => 'Varchar(255)',
    'ExtraMeta' => 'HTMLText',
    'ExtraScript' => 'HTMLText'
    ];

    private static $has_one = [];


	public function updateFieldLabels(&$labels) {
		$labels['MetaTitle'] = _t('SiteTree.METATITLE', "MetaTitel");
	}

    public function updateCMSFields(FieldList $fields){
    	$toExclude = Config::inst()->get("Deskall\SEO\SeoObjectExtension", "excluded_page_types");
		if (is_array($toExclude) && in_array($this->owner->getClassName(), $toExclude)) {
			return;
		}

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
}
