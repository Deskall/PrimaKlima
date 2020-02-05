<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\ORM\DataObject;
use SilverStripe\Subsite\Subsite;
use SilverStripe\Control\HTTPRequest;

class NewsController extends ContentController {

  private static $allowed_actions = array(
    'index',
    'details',
    'kategorie',
    'template'
  );

  public function index(){
    $page = Page::get()->filter(array('SubsiteID' => Subsite::currentSubsiteID(), 'URLSegment' => 'meldungen'))->first();
    if ($page){
      $this->redirect($page->Link());
    }
    else {
      $this->redirect('/');
    }

  }

  public function template(HTTPRequest $request) {
    $template = DataObject::get_by_id("NewsTemplate", $request->param('ID'));

    echo json_encode(array(
      'title' => $template->Title,
      'content' => $template->Lead,
    ));
  }



  public function details(HTTPRequest $request) {
    $url = 'details/'.$request->param('ID').'/'.$request->param('OtherID');
    $news = News::get()->filter('URLSegment',$url)->first();
    if (!$news){
      return $this->httpError(404,'Dieser Artikel wurde nicht gefunden.');
    }
    $title = $news->Title;
    $blocks = $news->Blocks();



    return array('News' => $news, 'Title' => $title, 'Blocks' => $blocks);
  }

  public function kategorie(HTTPRequest $request) {
    $category = NewsCategory::get()->filter('Title',$request->params('ID'))->first();
    if (!$category){
      return $this->httpError(404,'Diese Kategorie wurde nicht gefunden.');
    }
    $title = $category->Title;

    return array('Category' => $category, 'Title' => $title);
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
       if ($data['PublishDate']){
        $PublishDate = new \Datetime();
        $PublishDate->setTimestamp(strtotime($data['PublishDate']));
      } else {
        $PublishDate = null;
      }
        if ($data['ArchiveDate']){
           $ArchiveDate = new \Datetime();
           $ArchiveDate->setTimestamp(strtotime($data['ArchiveDate']));
        }
        else {
          $ArchiveDate = null;
        }
    if ( $PublishDate && $PublishDate->format('Y-m-d H:i:s') < date('Y-m-d H:i:s')){
        $this->validationError("PublishDate", "Das Datum der Veröffentlichung kann nicht in der Vergangenheit sein.", 'error');
        $valid = false;
      }
      if ( $ArchiveDate && $PublishDate && $PublishDate > $ArchiveDate){
        $this->validationError("ArchiveDate", "Das Datum der Archivierung muss nach dem Datum der Veröffentlichung sein.", 'error');
        $valid = false;
      }
    }
     $valid = parent::php($data);
     return $valid;
  }
}