<?php
/** THEME MODULE
* Allow definition of Menus and Footer
* @author: Deskall Kommunikation AG
*/
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Subsites\Extensions\SubsiteMenuExtension;

if(class_exists(Subsite::class)){
	ThemeLeftAndMain::add_extension(SubsiteMenuExtension::class);
}