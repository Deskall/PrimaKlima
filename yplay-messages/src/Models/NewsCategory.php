<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\View\Parsers\URLSegmentFilter;

class NewsCategory extends DataObject {

    private static $db = array(
        'Title' => 'Varchar(250)',
        'URLSegment' => 'Varchar(250)',
    );


    private static $belongs_many_many = array(
        "News" => News::class
    );

    static $singular_name = 'Kategorie';
    static $plural_name = 'Kategorien';

   public function getCMSFields() {

    $fields = parent::getCMSFields();
    $fields->addFieldToTab('Root.Main',TextField::create('Title','Kategorie Name'));
    $fields->removeByName('News');
    $fields->removeByName('URLSegment');
    return $fields;

  }

    public function onBeforeWrite(){
       if (!$this->URLSegment){
          $this->URLSegment = URLSegmentFilter::create()->filter($this->Title);
        }
        parent::onBeforeWrite();
    }
    public function Link() {
        $URLSegment = '/meldungen/kategorie/'.$this->URLSegment;
        return $URLSegment;
    }

}