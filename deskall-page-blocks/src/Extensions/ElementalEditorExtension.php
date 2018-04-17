<?php

use SilverStripe\ORM\DataExtension;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;


class ElementalEditorExtension extends DataExtension 
{
    public function updateGetTypes($types){
        

    }

     public function updateField($gridfield){
     	$types = $this->owner->getTypes();
        if ($this->owner->getArea()->getOwnerPage()->ClassName == "ParentBlock" && $this->owner->getArea()->getOwnerPage()->CollapsableChildren){
            $allowed = $this->owner->getArea()->getOwnerPage()->stat('allowed_collapsed_blocks');
            foreach ($types as $key => $value) {
                if (!in_array($key,$allowed)){
                    unset($types[$key]);
                }
            }
        }
        else{
            //unset non needed by deskall
            unset($types['SilverStripe\ElementalBlocks\Block\BannerBlock']);
            unset($types['DNADesign\Elemental\Models\ElementContent']);
            unset($types['SilverStripe\ElementalBlocks\Block\FileBlock']);
            unset($types['DNADesign\ElementalList\Model\ElementList']);
        }
    	$gridfield->getConfig()->removeComponentsByType(GridFieldAddNewMultiClass::class)
        ->addComponent(new DeskallGridFieldAddNewMultiClass());
        $gridfield->getConfig()->getComponentByType(DeskallGridFieldAddNewMultiClass::class)->setClasses($types);
        $gridfield->getConfig()->addComponent(new GridFieldShowHideAction());
        if ($this->owner->getArea()->getOwnerPage()->ClassName == "ParentBlock" && $this->owner->getArea()->getOwnerPage()->CollapsableChildren){
            $gridfield->getConfig()->addComponent(new GridFieldCollapseUncollapseAction());
        }
        $gridfield->getConfig()->addComponent(new GridFieldDuplicateBlock('toolbar-header-left'));
        if ($gridfield->name == "Elements"){
            $gridfield->getConfig()->addComponent(new GridFieldBlockOrderAction());
        }
    }
   

}