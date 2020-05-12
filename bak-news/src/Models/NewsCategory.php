<?php

namespace Bak\News\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\View\Parsers\URLSegmentFilter;

class NewsCategory extends DataObject {

  private static $db = array(
    'Title' => 'Varchar(250)',
    'URLSegment' => 'Varchar(250)',
  );


  private static $belongs_many_many = array(
    "News" => "News",
  );

  private static $singular_name = 'Kategorie';
  private static $plural_name = 'Kategorien';

  public function getCMSFields() {

    $fields =parent::getCMSFields();

    return $fields;

  }

  public function onBeforeWrite(){
     if (!$this->URLSegment){
        $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
      }
     
      parent::onBeforeWrite();
  }

  public function Link() {
    $URLSegment =  _t('BakNews.CategorySegment','neuigkeiten/kategorie/').$this->URLSegment;
    return $URLSegment;
  }

}