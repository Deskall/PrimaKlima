<?php

/*** deskall diverse custom code **/
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\SiteConfig\SiteConfig;

$editorCss = SiteConfig::current_site_config()->getCurrentThemeDir().'css/editor.css';

TinyMCEConfig::config()->set('editor_css', $editorCss);

