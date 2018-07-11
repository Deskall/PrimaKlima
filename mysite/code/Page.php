<?php

use SilverStripe\CMS\Model\SiteTree;
use g4b0\SearchableDataObjects\Searchable;

class Page extends SiteTree implements Searchable
{


     /**
      * Filter array
      * eg. array('Disabled' => 0);
      * @return array
      */
     public static function getSearchFilter() {
         return array();
     }

     /**
      * FilterAny array (optional)
      * eg. array('Disabled' => 0, 'Override' => 1);
      * @return array
      */
     public static function getSearchFilterAny() {
         return array();
     }

     /**
      * FilterByCallback function (optional)
      * eg. function($object){
      *  return ($object->StartDate > date('Y-m-d') || $object->isStillRecurring());
      * };
      * @return array
      */
     public static function getSearchFilterByCallback() {
         return function($object){ return true; };
     }

     /**
      * Fields that compose the Title
      * eg. array('Title', 'Subtitle');
      * @return array
      */
     public function getTitleFields() {
         return array('Title');
     }

     /**
      * Fields that compose the Content
      * eg. array('Teaser', 'Content');
      * @return array
      */
     public function getContentFields() {
         return array();
     }
}