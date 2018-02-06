<?php

use SilverStripe\CMS\Model\SiteTree;

class Page extends SiteTree
{
    private static $db = [];

    private static $has_one = [];

    public function ThemeDir(){
    	return ThemeResourceLoader::inst()->getThemePaths(SSViewer::get_themes())[0];
    }
}
