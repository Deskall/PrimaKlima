<?php

/*** deskall diverse custom code **/
use SilverStripe\Forms\HTMLEditor\TinyMCEConfig;
use SilverStripe\SiteConfig\SiteConfig;

$editorCss = SiteConfig::current_site_config()->getCurrentThemeDir().'css/editor.css';

ob_start();
			print_r($editorCss);
			$result = ob_get_clean();
			file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);

TinyMCEConfig::config()->merge('editor_css', $editorCss);

