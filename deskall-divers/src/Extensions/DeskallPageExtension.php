<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;
use SilverStripe\Control\Director;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Subsites\Extensions\SiteTreeSubsites;
use SilverStripe\Subsites\Extensions\FileSubsites;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Subsites\State\SubsiteState;
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

    public function generateFolderName(){
        if ($this->owner->ID > 0){
            if ($this->owner->ParentID > 0 && $this->owner->Parent()->hasMethod('generateFolderName')){
                return $this->owner->Parent()->generateFolderName()."/".$this->owner->URLSegment;
            }
            else{
                if ($this->owner->hasExtension(SiteTreeSubsites::class)){
                    $config = SiteConfig::current_site_config();
                    $prefix = URLSegmentFilter::create()->filter($config->Title);
                    return "Uploads/".$prefix.'/'.$this->owner->URLSegment;
                }
                return "Uploads/".$this->owner->URLSegment;
            }
        }
        else{
            return "Uploads/tmp";
        }
        
    }

    public function onBeforeWrite(){
        if ($this->owner->ID > 0){
            $changedFields = $this->owner->getChangedFields();
            //Update Folder Name
            if ($this->owner->isChanged('URLSegment') && ($changedFields['URLSegment']['before'] != $changedFields['URLSegment']['after'])){
                $oldFolderPath = ($this->owner->ParentID > 0 ) ? $this->owner->Parent()->generateFolderName()."/".$changedFields['URLSegment']['before'] : (($this->owner->hasExtension(SiteTreeSubsites::class)) ? "Uploads/".URLSegmentFilter::create()->filter(SiteConfig::current_site_config()->Title)."/".$changedFields['URLSegment']['before'] : "Uploads/".$changedFields['URLSegment']['before']);
                $newFolder = Folder::find_or_make($oldFolderPath);
                if ($newFolder->hasExtension(FileSubsites::class)){
                    $newFolder->SubsiteID = SubsiteState::singleton()->getSubsiteId();
                }
                $newFolder->Name = $changedFields['URLSegment']['after'];
                $newFolder->Title = $changedFields['URLSegment']['after'];
                $newFolder->write();
            }
            //Update Folder Structure
            if($this->owner->isChanged('ParentID')){
                $oldParent = ($changedFields['ParentID']['before'] == 0) ? null : DataObject::get_by_id(Page::class,$changedFields['ParentID']['before']);
                $oldFolderPath = ($oldParent) ? $oldParent->generateFolderName()."/".$this->owner->URLSegment : (($this->owner->hasExtension(SiteTreeSubsites::class)) ? "Uploads/".URLSegmentFilter::create()->filter(SiteConfig::current_site_config()->Title)."/".$this->owner->URLSegment : "Uploads/".$this->owner->URLSegment);
                $oldFolder = Folder::find_or_make($oldFolderPath);
                if ($oldFolder->hasExtension(FileSubsites::class)){
                    $oldFolder->SubsiteID = SubsiteState::singleton()->getSubsiteId();
                }
                $newParent = ($changedFields['ParentID']['after'] == 0) ? null : DataObject::get_by_id(Page::class,$changedFields['ParentID']['after']);
                $newParentFolderPath = ($newParent) ? $newParent->generateFolderName() : (($this->owner->hasExtension(SiteTreeSubsites::class)) ? "Uploads/".URLSegmentFilter::create()->filter(SiteConfig::current_site_config()->Title) : "Uploads");
                $newParentFolder = Folder::find_or_make($newParentFolderPath);
                if ( $newParentFolder->hasExtension(FileSubsites::class)){
                     $newParentFolder->SubsiteID = SubsiteState::singleton()->getSubsiteId();
                }
                $oldFolder->ParentID = $newParentFolder->ID;
                $oldFolder->write();
            }
        }
        else{
            if ($this->owner->getPageLevel() == 1){
                $this->owner->ShowInMainMenu = true;
            }
        }
        
        parent::onBeforeWrite();
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