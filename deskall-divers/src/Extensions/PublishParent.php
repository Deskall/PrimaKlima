<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Models\ElementalArea;

class PublishParent extends DataExtension
{

    /*** Loop recursively until we reach first parent page then publish it *****/
    public function onAfterVersionedPublish($fromStage, $toStage, $createNewVersion){
        if (!$this->owner instanceof SiteTree && !$this->owner instanceof ElementalArea ){
            if ($toStage == "Live"){
                if ($parent = $this->owner->getPage()){
                    while(!$parent instanceof SiteTree){
                        $parent = $parent->getPage();
                    }
                    $parent->publishSingle();
                    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/log.txt','ici');
                }
            }
            
        }
    }
        
}