<?php

namespace Deskall\SEO;

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\HeaderField;

/**
 * SeoSiteConfig
 * adds site-wide settings for SEO
 */
class SeoSiteConfigExtension extends DataExtension {

	private static $db = array(
		'GoogleWebmasterMetaTag' => 'Varchar(512)',
        'HeadScripts' => 'HTMLText',
        'BodyScripts' => 'HTMLText'
	);

    private static $has_one = ['OpenGraphDefaultImage' => Image::class];

    private static $owns = ['OpenGraphDefaultImage'];

	/**
	 * updateCMSFields.
 	 * Update Silverstripe CMS Fields for SEO Module
 	 *
	 * @param FieldList
	 * @return $fields
	 */
	public function updateCMSFields(FieldList $fields) {

        $fields->addFieldsToTab("Root.SEO",array(
                HeaderField::create('ScriptTitle','Google Scripts',3)
                ->setRightTitle(
                    _t(
                        'SEO.ScriptTitle',
                        "Geben Sie hier alle Skripte an, die auf allen Seiten der Site hinzugefügt werden sollen."
                    )
                ),
                TextareaField::create("HeadScripts", _t('SEO.HeadScripts', 'Skripte für Head'))
                ->setRightTitle(
                    _t(
                        'SEO.HeadScriptsRightTitle',
                        "Fügen Sie Ihre alle Skripte, die im Header hinzugefügt werden sollen."
                    )
                ),
                TextareaField::create("BodyScripts", _t('SEO.BodyScripts', 'Skripte für Body'))
                ->setRightTitle(
                    _t(
                        'SEO.BodyScriptsRightTitle',
                        "Fügen Sie Ihre alle Skripte, die im Body hinzugefügt werden sollen."
                    )
                ),
                TextareaField::create("GoogleWebmasterMetaTag", _t('SEO.SEOGoogleWebmasterMetaTag', 'Google webmaster meta tag'))
                ->setRightTitle(
                    _t(
                        'SEO.SEOGoogleWebmasterMetaTagRightTitle',
                        "Google webmaster meta tag Zum Beispiel <meta name=\"google-site-verification\" content=\"hjhjhJHG12736JHGdfsdf\" />"
                    )
                ),
                UploadField::create("OpenGraphDefaultImage",'Vorschau Bild für Shares')->setFolderName($this->owner->getFolderName())
            )
        );

    }


}
