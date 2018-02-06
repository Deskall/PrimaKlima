<?php

namespace Deskall\SEO;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FieldList;

/**
 * SeoSiteConfig
 * adds site-wide settings for SEO
 */
class SeoSiteConfigExtension extends DataExtension {

	private static $db = array(
		'GoogleWebmasterMetaTag' => 'Varchar(512)',
        'GoogleAnalyticsCode' => 'HTMLText',
	);


	/**
	 * updateCMSFields.
 	 * Update Silverstripe CMS Fields for SEO Module
 	 *
	 * @param FieldList
	 * @return $fields
	 */
	public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab("Root.SEO",array(
                TextareaField::create("GoogleAnalyticsCode", _t('SEO.SEOGoogleAnalyticsCode', 'Google Analytics Script'))
                ->setRightTitle(
                    _t(
                        'SEO.SEOGoogleAnalyticsCodeRightTitle',
                        "Füngen Sie Ihre Google Analytics Script hier."
                    )
                ),
                TextareaField::create("GoogleWebmasterMetaTag", _t('SEO.SEOGoogleWebmasterMetaTag', 'Google webmaster meta tag'))
                ->setRightTitle(
                    _t(
                        'SEO.SEOGoogleWebmasterMetaTagRightTitle',
                        "Google webmaster meta tag Zum Beispiel <meta name=\"google-site-verification\" content=\"hjhjhJHG12736JHGdfsdf\" />"
                    )
                )
            )
        );

    }


}
