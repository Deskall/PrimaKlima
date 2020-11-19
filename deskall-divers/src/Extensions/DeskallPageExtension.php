<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Control\Director;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Injector\Injector;

class DeskallPageExtension extends DataExtension
{
     private static $db = [
        'TitleDisplayed' => 'Text',
        'ShowInMainMenu' => 'Int'
    ];

    private static $has_one = [];

    private static $menu_level = [
        '0' => 'Nicht in Menüs anzeigen',
        '1' => 'Hauptnavigation',
        '2' => 'Untennavigation',
        '3' => 'Beide'
    ];

    public function ThemeDir(){
        return SiteConfig::current_site_config()->getCurrentThemeDir();
    }

     public function CurrentThemeDir(){
        return SiteConfig::current_site_config()->getCurrentThemeDir();
    }

    public function LastChangeJS(){
        $srcDir = Director::baseFolder().'/themes/standard/javascript/vendor';
        $srcFiles = array_diff(scandir($srcDir), array('.', '..'));
        $filetime = 0;
        foreach($srcFiles as $key => $file) {
            if( filemtime($srcDir."/".$file) > $filetime)
            {
                $filetime = filemtime($srcDir."/".$file);
            }
        }
        return $filetime;
    }

    public function updateCMSFields(FieldList $fields){
        $fields->insertAfter('Title',TextareaField::create('TitleDisplayed','Seiten Titel')->setRows(2));
        if ($this->owner->ShowInMenus ){
            $field = OptionsetField::create('ShowInMainMenu',_t(__CLASS__.'.ShowInMainMenuLabel','In welchem Menu sollt diese Seite anzeigen ?'), $this->owner->getTranslatedSourceFor(__CLASS__,'menu_level'));
            $fields->insertAfter($field,'MenuTitle');
        }
    }

    public function getPrivatePolicyPage(){
      return PrivatePolicyPage::get()->first();
    }

    //search related
    public function notInListYet( $link ){
      $request = Injector::inst()->get(HTTPRequest::class);
      $session = $request->getSession();

      $results = ( $session->get('searchresults') ) ?  $session->get('searchresults') : array();
    

      if( !in_array($link, $results) ){
        array_push($results, $link);
        $session->set('searchresults',$results);
        return 1;
      }else{
        return 0;
      }
    }

    public function clearSearchresultSession(){
      $request = Injector::inst()->get(HTTPRequest::class);
      $session = $request->getSession();
      $session->clear('searchresults');
    }



      /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('menu_level') as $key => $value) {
          $entities[__CLASS__.".menu_level_{$key}"] = $value;
        }

        return $entities;
    }

    /************* END TRANLSATIONS *******************/
}