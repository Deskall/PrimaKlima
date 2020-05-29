<?php

use SilverStripe\CMS\Model\SiteTree;
use g4b0\SearchableDataObjects\Searchable;

use SilverStripe\Forms\TextareaField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class Page extends SiteTree implements Searchable
{

    public function getCMSFields(){
      $fields = parent::getCMSFields();
      $fields->replaceField('Title',TextareaField::create('Title',$this->fieldLabel('Title'))->setRows(2));

      return $fields;
    }

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

     //search related
     public function notInListYet( $link ){
      $request = Injector::inst()->get(HTTPRequest::class);
      $session = $request->getSession();

      $results = ( $session->get('searchresults') ) ?  $session->get('searchresults') : array();
 

      if( !in_array($link, $results) ){
        array_push($results, $link);
        $session->set('searchresults',$results);
        return 1;
      }else{
        return 0;
      }
    }

    public function clearSearchresultSession(){
      $request = Injector::inst()->get(HTTPRequest::class);
      $session = $request->getSession();
      $session->clear('searchresults');
    }


    public function getPrivatePolicyPage(){
      return PrivatePolicyPage::get()->first();
    }
   
}

