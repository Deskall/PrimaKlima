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

class DeskallPageExtension extends DataExtension
{
	 private static $db = [
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
    	return ThemeResourceLoader::inst()->getThemePaths(SSViewer::get_themes())[0];
    }

    public function updateCMSFields(FieldList $fields){
        if ($this->owner->ShowInMenus ){
            $field = OptionsetField::create('ShowInMainMenu',_t(__CLASS__.'.ShowInMainMenuLabel','In welchem Menu sollt diese Seite anzeigen ?'), $this->owner->getTranslatedSourceFor(__CLASS__,'menu_level'));
            $fields->insertAfter($field,'MenuTitle');
        }
    }


    public function generateFolderName(){
    	if ($this->owner->ID > 0){
    		if ($this->owner->ParentID > 0){
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
                    $newFolder->SubsiteID = Subsite::currentSubsiteID();
                }
                $newFolder->Name = $changedFields['URLSegment']['after'];
                $newFolder->Title = $changedFields['URLSegment']['after'];
                $newFolder->write();
            }
            //Update Folder Structure
            if($this->owner->isChanged('ParentID')){
                $oldParent = ($changedFields['ParentID']['before'] == 0) ? null : DataObject::get_by_id(SiteTree::class,$changedFields['ParentID']['before']);
                $oldFolderPath = ($oldParent) ? $oldParent->generateFolderName()."/".$this->owner->URLSegment : (($this->owner->hasExtension(SiteTreeSubsites::class)) ? "Uploads/".URLSegmentFilter::create()->filter(SiteConfig::current_site_config()->Title)."/".$this->owner->URLSegment : "Uploads/".$this->owner->URLSegment);
                $oldFolder = Folder::find_or_make($oldFolderPath);
                if ($oldFolder->hasExtension(FileSubsites::class)){
                    $oldFolder->SubsiteID = Subsite::currentSubsiteID();
                }
                $newParent = ($changedFields['ParentID']['after'] == 0) ? null : DataObject::get_by_id(SiteTree::class,$changedFields['ParentID']['after']);
                $newParentFolderPath = ($newParent) ? $newParent->generateFolderName() : (($this->owner->hasExtension(SiteTreeSubsites::class)) ? "Uploads/".URLSegmentFilter::create()->filter(SiteConfig::current_site_config()->Title) : "Uploads");
                $newParentFolder = Folder::find_or_make($newParentFolderPath);
                if ( $newParentFolder->hasExtension(FileSubsites::class)){
                     $newParentFolder->SubsiteID = Subsite::currentSubsiteID();
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