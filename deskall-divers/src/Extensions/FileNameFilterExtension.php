<?php
use SilverStripe\Core\Extension;

class FileNameFilterExtension extends Extension{
	 private static $default_replacements = [
	  '/\.(?=.*?\.)/' => '-' // Remove all leading dots, dashes or underscores
     ];
}