<?php

namespace Bak\Products;

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\GridField\GridFieldExportButton;
use SilverStripe\Forms\GridField\GridFieldPrintButton;
use Bak\News\Forms\GridFieldPublishNews;
use Bak\News\Models\NewsCategory;
use Bak\News\Models\News;

class NewsAdmin extends ModelAdmin {

    private static $managed_models = array(
        News::class,
        NewsCategory::class
    );

    private static $menu_priority = 2;
    private static $menu_icon = 'bak-news/img/news.png';

    private static $url_segment = 'news';
    private static $menu_title = 'Neuigkeiten';
    public $showImportForm = false;



    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);
        if($this->modelClass== News::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass)))
        {
            print_r($form->Fields);
            $form->Fields()->fieldByName("News")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("News")->getConfig()->removeComponentsByType(GridFieldPrintButton::class);  
            $form->Fields()->fieldByName("News")->getConfig()->addComponent(new GridFieldPublishNews());
        }
        if($this->modelClass== NewsCategory::class && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) 
        {
            $form->Fields()->fieldByName("NewsCategory")->getConfig()->removeComponentsByType(GridFieldExportButton::class);
            $form->Fields()->fieldByName("NewsCategory")->getConfig()->removeComponentsByType(GridFieldPrintButton::class); 
        }
        return $form;
    }
}



