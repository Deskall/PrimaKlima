<?php

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\Director;

ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

class PayPalClient
{
    /**
     * Returns PayPal HTTP client instance with environment that has access
     * credentials context. Use this instance to invoke PayPal APIs, provided the
     * credentials have access.
     */
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    /**
     * Set up and return PayPal PHP SDK environment with PayPal access credentials.
     * This sample uses SandboxEnvironment. In production, use ProductionEnvironment.
     */
    public static function environment()
    {
        $clientId = SiteConfig::current_site_config()->PayPalClientID;
        $clientSecret = SiteConfig::current_site_config()->PayPalSecret;
        if (Director::AbsoluteBaseUrl() == "https://www.schneider-mietkochagentur.de/" || Director::AbsoluteBaseUrl() == "https://www.schneider-hotelgastro-consulting.ch/" ){
            ob_start();
        print_r('live');
        $result = ob_get_clean();
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/logi.txt", $result);
            return new ProductionEnvironment($clientId, $clientSecret);
        }
         ob_start();
        print_r('sandbox');
        $result = ob_get_clean();
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/logi.txt", $result);
        return new SandboxEnvironment($clientId, $clientSecret);
    }
}