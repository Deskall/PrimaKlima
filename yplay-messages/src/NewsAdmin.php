<?php
use SilverStripe\Admin\ModelAdmin;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class NewsAdmin extends ModelAdmin {

    public function subsiteCMSShowInMenu(){
        return true;
    }

   private static $managed_models = array(
       'News' => array ('title' => 'Meldungen'),
       'NewsTemplate' => array ('title' => 'Meldungsvorlagen'),
   );



    static $menu_priority = 6;
//    static $menu_icon = 'deskall-news/img/news-16x16.png';
    static $menu_icon = 'yplay-messages/images/icon-info.png';
    private static $url_segment = 'notifications';
    private static $menu_title = 'Meldungen';
    public $showImportForm = false;

    public function getEditForm($id = null, $fields = null) {
        $form = parent::getEditForm($id, $fields);

        if($this->modelClass=='News' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) 
        {
            $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
            $form->Fields()->fieldByName("News")->getConfig()->addComponent(new GridFieldDuplicateAction());
        }

        if($this->modelClass=='NewsTemplate' && $gridField=$form->Fields()->dataFieldByName($this->sanitiseClassName($this->modelClass))) 
        {
            $gridField->getConfig()->addComponent(new GridFieldOrderableRows('SortOrder'));
        }

        return $form;
    }

    public function getList(){
        $list = parent::getList();
        $list =  $list->filter('SubsiteID',Subsite::currentSubsiteID());
        return $list;
    }
}

