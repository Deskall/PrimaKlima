<?php
/** Legacy extension for migration of deprecated Blocks **/

use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;

class ElementFormExtension extends DataExtension
{

   private static $db = [
    'ButtonBackground' => 'Varchar(255)',
    'HTML' => 'HTMLText'
   ];

   private static $has_one = [
    'RedirectPage' => SiteTree::class
   ];

}
