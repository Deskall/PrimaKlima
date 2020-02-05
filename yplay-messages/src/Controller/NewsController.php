<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\HTTPRequest;


class NewsController extends ContentController {

  private static $allowed_actions = array(
    'template'
  );


  public function template(HTTPRequest $request) {
    $template = NewsTemplate::get()->byId($request->param('ID'));

    echo json_encode(array(
      'title' => $template->Title,
      'content' => $template->Lead,
    ));
  }


}