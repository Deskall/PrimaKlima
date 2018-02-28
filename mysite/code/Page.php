<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldList;
use SilverStripe\View\ThemeResourceLoader;
use SilverStripe\View\SSViewer;

class Page extends SiteTree
{
    private static $db = [
        'ShowInMainMenu' => 'Boolean(1)'
    ];

    private static $has_one = [];

    public function ThemeDir(){
    	return ThemeResourceLoader::inst()->getThemePaths(SSViewer::get_themes())[0];
    }

    public function getSettingsFields(){
        $fields = parent::getSettingsFields();
        $field = CheckboxField::create('ShowInMainMenu','Diese Seite im Hauptmenu anzeigen?');
        $fields->insertAfter($field,'ShowInMenus');

        return $fields;
    }


    public function generateFolderName(){
    	if ($this->ID > 0){
    		if ($this->ParentID > 0){
	    		return $this->Parent()->generateFolderName()."/".$this->URLSegment;
	    	}
	    	else{
	    		return "Uploads/".$this->URLSegment;
	    	}
    	}
    	else{
    		return "Uploads/tmp";
    	}
    	
    }

    public function onBeforeWrite(){
    	if ($this->ID > 0){
            $changedFields = $this->getChangedFields();
            //Update Folder Name
            if ($this->isChanged('URLSegment') && ($changedFields['URLSegment']['before'] != $changedFields['URLSegment']['after'])){
                $oldFolderPath = ($this->ParentID > 0 ) ? $this->Parent()->generateFolderName()."/".$changedFields['URLSegment']['before'] : "Uploads/".$changedFields['URLSegment']['before'];
                $newFolder = Folder::find_or_make($oldFolderPath);
                $newFolder->Name = $changedFields['URLSegment']['after'];
                $newFolder->Title = $changedFields['URLSegment']['after'];
                $newFolder->write();
            }
            //Update Folder Structure
            if($this->isChanged('ParentID')){
                $oldParent = ($changedFields['ParentID']['before'] == 0) ? null : DataObject::get_by_id(SiteTree::class,$changedFields['ParentID']['before']);
                $oldFolderPath = ($oldParent) ? $oldParent->generateFolderName()."/".$this->URLSegment : "Uploads/".$this->URLSegment;
                $oldFolder = Folder::find_or_make($oldFolderPath);

                $newParent = ($changedFields['ParentID']['after'] == 0) ? null : DataObject::get_by_id(SiteTree::class,$changedFields['ParentID']['after']);
                $newParentFolderPath = ($newParent) ? $newParent->generateFolderName() : "Uploads";
                $newParentFolder = Folder::find_or_make($newParentFolderPath);
                
                $oldFolder->ParentID = $newParentFolder->ID;
                $oldFolder->write();
            }
        }
    	
    	parent::onBeforeWrite();
    }

    public function requireDefaultRecords()
    {
        parent::requireDefaultRecords();

       // TO DO  : other Page
    }

    public function IsLive() {
        return Director::isLive();
    }

    public function Css(){
        return file_get_contents(Director::baseFolder().'/'.$this->ThemeDir().'/css/main.min.css');
    }

}
