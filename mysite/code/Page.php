<?php

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\DataObject;

class Page extends SiteTree
{
    private static $db = [];

    private static $has_one = [];

    public function ThemeDir(){
    	return ThemeResourceLoader::inst()->getThemePaths(SSViewer::get_themes())[0];
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
    	parent::onBeforeWrite();
    }
}
