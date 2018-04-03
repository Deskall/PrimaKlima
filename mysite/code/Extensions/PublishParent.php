<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Model\SiteTree;

class PublishParent extends DataExtension
{

    /*** Loop recursively until we reach first parent page then publish it *****/
    public function onAfterVersionedPublish($fromStage, $toStage, $createNewVersion){
        if (!$this->owner instanceof SiteTree ){
            if ($toStage == "Live"){
                if ($parent = $this->owner->getPage()){
                    while(!$parent instanceof SiteTree){
                        $parent = $parent->getPage();
                    }
                    $parent->doPublish();
                }
            }
            
        }
    }
        
}