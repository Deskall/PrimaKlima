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
    	unset($types['DNADesign\Elemental\Models\ElementContent']);
        unset($types['SilverStripe\ElementalBlocks\Block\FileBlock']);
        unset($types['DNADesign\ElementalList\Model\ElementList']);
    	$gridfield->getConfig()->removeComponentsByType(GridFieldAddNewMultiClass::class)
        ->addComponent(new DeskallGridFieldAddNewMultiClass());
        $gridfield->getConfig()->getComponentByType(DeskallGridFieldAddNewMultiClass::class)->setClasses($types);
        $gridfield->getConfig()->addComponent(new GridFieldShowHideAction());
        if ($gridfield->name == "Elements"){
            $gridfield->getConfig()->addComponent(new GridFieldBlockOrderAction());
        }
    }
   

}