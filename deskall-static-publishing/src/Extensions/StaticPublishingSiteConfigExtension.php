<?php

use SilverStripe\Admin\LeftAndMainExtension;
use SilverStripe\SiteConfig\SiteConfig;

class StaticPublishingSiteConfigExtension extends LeftAndMainExtension
{

    private static $allowed_actions = [
        'flushChanges'
    ];

    public function flushChanges()
    {
        SiteConfig::current_site_config()->flushChanges();
        $this->owner->getResponse()->addHeader('X-Status', rawurlencode(_t('SiteConfig' . '.FLUSHEDCACHE', 'HTML Cache wurde aktualisiert')));
    }

}