<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Subsites\State\SubsiteState;

class NewsController extends ContentController {

  private static $allowed_actions = array(
    'index',
    'details',
    'template'
  );

  public function index(){
    $page = Page::get()->filter(array('SubsiteID' => SubsiteState::singleton()->getSubsiteId(), 'URLSegment' => 'meldungen'))->first();
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


}