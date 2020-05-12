<?php

namespace Bak\News\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use BAK\News\Models\NewsCategory;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\Control\Director;
use SilverStripe\View\Parsers\URLSegmentFilter;


class News extends DataObject {
  private static $singular_name = 'Neuigkeit';
  private static $plural_name = 'Neuigkeiten';
  private static $table_name = 'BAK_News';

  private static $db = array(
    'Title' => 'Varchar(250)',
    'Lead' => 'Text',
    'Content' => 'HTMLText',
    'URLSegment' => 'Varchar(250)',
    'PublishDate' => 'Datetime',
    'ArchiveDate' => 'Datetime',
    'Status' => 'Varchar(250)'
  );

  private static $defaults = array(
    'Title' => 'Neuer Eintrag',
    'URLSegment' => 'neuer-eintrag',
    'Status' => 'ToBePublished'
  );

  private static $indexes = array(
    'URLSegment' => true
  );

  private static $has_one = array(
    'Image' => Image::class
  );

  private static $many_many = array(
    'Categories' => NewsCategory::class
  );

  private static $summary_fields = array (
    'Title' => array('title' => 'Titel'),
    'showCategories' => 'Kategorien'
  );

  protected function showCategories() {
    $categories = $this->Categories();
    $str = '';
    foreach ($categories as $category )
      $str = $str.$category->Title.',';

    return $str;
  }

  function getCMSValidator(){
   return new News_Validator();
 }

 public function getCMSFields() {
  $fields = parent::getCMSFields();
  // $fields->removeByName('Status');
  return $fields;
}



public function onBeforeWrite(){

  // $oldFolderName =  "Uploads/news-detail/".$this->URLSegment;

  // if($this->isChanged('Title')){
  //   $this->URLSegment = URLSegmentFilter::create()->filter($this->Title); 
  //   $newFolderName = "Uploads/news-detail/".$this->URLSegment; 

  //   if ( strcmp($oldFolderName, $newFolderName) != 0)   {
  //     $imageFolder = Folder::find($oldFolderName);

  //     if($imageFolder){
  //       $imageFolder->setName(basename($newFolderName));
  //       $imageFolder->write();
  //     }
  //   }
  // }



  parent::onBeforeWrite();
}



// public function hasCategory($ID){

//   $query = new SQLQuery();

//   $query->setFrom('News_Categories')->setSelect('COUNT(*)')->addWhere('NewsID = '.$this->ID)->addWhere('NewsCategoryID = '.$ID);

//   $count = $query->execute()->value();

//   return ($count > 0) ? true : false;

// }

public function canPublish(){
  return !$this->Status == "published";
}

public function canArchive(){
  return $this->Status == "published";
}

public function doArchive(){
  $this->Status = "archived";
  $this->ArchiveDate = new \Datetime();
  $this->write();
}

public function doPublish(){
  $this->Status = "published";
  $this->PublishDate = date();
  $this->write();
}

  /**
     * Link to this DO
     * @return string
     */
  public function Link() {
    return _t('BakNews.Detail','detail').'/'.$this->URLSegment;
  }

    /**
       * Aboslute Link to this DO
       * @return string
       */
    public function AbsoluteLink() {
      return Director::absoluteURL($this->Link());
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
      return array('Lead');
    }
  }


/**
 * News Validator
 *
 * @author deskall
 */
class News_Validator extends RequiredFields {
  protected $customRequired = array('Title');

  /**
   * Constructor
   */
  public function __construct() {
    $required = func_get_args();
    if(isset($required[0]) && is_array($required[0])) {
      $required = $required[0];
    }
    $required = array_merge($required, $this->customRequired);
    parent::__construct($required);
  }

  /**
   * Check if the submitted member data is valid (server-side)
   *
   * Check if a news publish and archive dates are consistent
   *
   * @param array $data Submitted data
   * @return bool Returns TRUE if the submitted data is valid, otherwise
   *              FALSE.
   * @author deskall
   */
  function php($data) {
    if ($data['Status'] == "ToBePublished"){
      $PublishDate = new \Datetime();
      $PublishDate->setTimestamp(strtotime($data['PublishDate']));
      $ArchiveDate =  ($data['ArchiveDate']) ? new \Datetime() : null;
      
      if ($PublishDate->format('Y-m-d') < date('Y-m-d H:i:s')){
        $this->validationError("PublishDate", "Das Datum der Veröffentlichung kann nicht in der Vergangenheit sein.", 'error');
        $valid = false;
      }
      if ($ArchiveDate){
        $ArchiveDate->setTimestamp(strtotime($data['ArchiveDate']));
        if ($PublishDate > $ArchiveDate){
          $this->validationError("ArchiveDate", "Das ArchivesDatum muss nach dem Datum der Veröffentlichung sein.", 'error');
          $valid = false;
        }
      }
    }
    $valid = parent::php($data);
    return $valid;
  }
}