<?php
/** THEME MODULE
* Allow definition of Menus and Footer
* @author: Deskall Kommunikation AG
*/
use SilverStripe\Subsites\Model\Subsite;

if(class_exists(Subsite::class)){
	ThemeLeftAndMain::add_extension('SubsiteMenuExtension');
}