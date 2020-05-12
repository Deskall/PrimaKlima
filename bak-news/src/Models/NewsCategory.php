<?php

namespace Bak\News\Models;

class NewsCategory extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(250)',
        'URLSegment' => 'Varchar(250)',
    );


    private static $belongs_many_many = array(
    "News" => "News",
    );

    static $singular_name = 'Kategorie';
    static $plural_name = 'Kategorien';

   public function getCMSFields() {

    $fields = new FieldList();

    $fields->add($this->getTranslatableTabSet());
    $fields->removeByName('URLSegment');
    $fields->removeByName('URLSegment__en_US');
    return $fields;

  }

  public function onBeforeWrite(){
     if (!$this->URLSegment){
        $this->URLSegment = singleton('SiteTree')->generateURLSegment($this->Title);
      }
      if (!$this->URLSegment__en_US){
        $this->URLSegment__en_US = singleton('SiteTree')->generateURLSegment($this->Title__en_US);
      }
      parent::onBeforeWrite();
  }

    public function Link($Locale) {

        $URLSegment = ($Locale == 'de_DE') ? '/neuigkeiten/kategorie/'.$this->URLSegment : '/news/category/'.$this->URLSegment__en_US;
        return $URLSegment;
    }


}