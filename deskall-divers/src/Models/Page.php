<?php

use SilverStripe\CMS\Model\SiteTree;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\TextField;

class Page extends SiteTree implements Searchable
{
    private static $db = [
      'ExtraHeaderClass' => 'Varchar'
    ];

    public function fieldLabels($includerelation = true){
      $labels = parent::fieldLabels($includerelation);
      $labels['ExtraHeaderClass'] = _t('Page.ExtraHeaderClass','Custom CSS Class für der Header');

      return $labels;
    }


    public function getCMSFields(){
      $fields = parent::getCMSFields();
      $fields->addFieldToTab('Root.Layout',TextField::create('ExtraHeaderClass',$this->fieldLabels()['ExtraHeaderClass']));
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
      $this->session_start();
      if( !isset($_SESSION['searchresults'] )){
        $_SESSION['searchresults'] = array();
      }

      if( !in_array($link, $_SESSION['searchresults']) ){
        array_push($_SESSION['searchresults'], $link);
        return 1;
      }else{
        return 0;
      }
    }

    public function clearSearchresultSession(  ){
      $this->session_start();
      $_SESSION['searchresults'] = array();
    }

    function session_start() {
      if ( ! session_id() ) {
        @session_start();
      }
    }
}

