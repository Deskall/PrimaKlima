<?php

namespace Bak\News\Controllers;

use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\ManyManyList;
use Bak\News\Models\News;
use SilverStripe\ORM\FieldType\DBHTMLText;

class NewsPageController extends PageController {

    public function onBeforeInit() {
        $date = date('Y-m-d H:i:s');
        $toPublishNews =  News::get()->filter(array('Status' => 'ToBePublished', 'PublishDate:LessThan' => $date));
        foreach ($toPublishNews as $new){
            $new->Status = "Published";
            $new->write();
        }
        $toArchiveNews =  News::get()->filter(array('Status' => 'Published','ArchiveDate:LessThan' => $date));
        foreach ($toArchiveNews as $new){
            $new->Status = "Archived";
            $new->write();
        }
    }

    private static $allowed_actions = array(
        'detail'
    );

    private static $url_handlers = array (
        'detail/$News' => 'detail',
        'detalle/$News' => 'detail'
    );

    public function NewsList(){

        if ($this->Category()->ID > 0){
            $news = ManyManyList::create("News","News_Categories","NewsID","NewsCategoryID")->filter('Status','published')->sort(array('Created' => 'DESC'));
        }
        else {
            $news = News::get()->filter('Status','published')->sort(array('Created' => 'DESC'));
        }
        return $news;
    }

    public function detail(HTTPRequest $request ){
        if ($request->param('News')){
            $news = News::get()->filter(array('URLSegment' => $request->param('News')))->first();

            if(!$news) {
                return $this->httpError(404,'Diese Neuigkeit war nicht gefunden.');
            }
            $title = $news->Title;

            return array (
                'News' => $news,
                'Title' => $title,
                'MetaTags' => $this->NewsMetaTags($news)
            );
        }

        return $this->httpError(404,'Diese Neuigkeit war nicht gefunden.');
    }

    public function NewsMetaTags($news) {
        $tags = '<meta name="generator" content="SilverStripe - http://silverstripe.org"><meta http-equiv="Content-type" content="text/html; charset=utf-8">';
        $tags .= '<meta name="description" content="'.strip_tags($news->Lead).'">';

        return DBHTMLText::create()->setValue($tags);
    }
}