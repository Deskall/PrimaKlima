<?php

use SilverStripe\ORM\DataExtension;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;

class ElementalEditorExtension extends DataExtension 
{
    public function updateGetTypes($types){


    }

     public function updateField($gridfield){
     	$types = $this->owner->getTypes();
     	//unset non needed by deskall
    	unset($types['SilverStripe\ElementalBlocks\Block\BannerBlock']);
    	$gridfield->getConfig()->getComponentByType(GridFieldAddNewMultiClass::class)->setClasses($types);
        $gridfield->getConfig()->addComponent(new GridFieldShowHideAction());
    }
   

}