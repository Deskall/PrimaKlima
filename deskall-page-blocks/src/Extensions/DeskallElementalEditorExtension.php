<?php

use SilverStripe\ORM\DataExtension;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use DNADesign\ElementalVirtual\Forms\ElementalGridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;

class DeskallElementalEditorExtension extends DataExtension 
{
    public function updateGetTypes(&$types){

        // if ($this->owner->getArea()->getOwnerPage() && $this->owner->getArea()->getOwnerPage()->ClassName == "ParentBlock" && $this->owner->getArea()->getOwnerPage()->CollapsableChildren){
        //     $allowed = $this->owner->getArea()->getOwnerPage()->stat('allowed_collapsed_blocks');
        //     foreach ($types as $key => $value) {
        //         if (!in_array($key,$allowed)){
        //             unset($types[$key]);
        //         }
        //     }
        // }
        // else{
            //unset non needed by deskall
            unset($types['SilverStripe\ElementalBlocks\Block\BannerBlock']);
            unset($types['DNADesign\Elemental\Models\ElementContent']);
            unset($types['SilverStripe\ElementalBlocks\Block\FileBlock']);
            unset($types['DNADesign\ElementalList\Model\ElementList']);
        // }
    }

     public function updateField($gridfield){
     	$types = $this->owner->getTypes();
        
    	$gridfield->getConfig()->removeComponentsByType(GridFieldAddNewMultiClass::class)
        ->addComponent(new DeskallGridFieldAddNewMultiClass());
        $gridfield->getConfig()->getComponentByType(DeskallGridFieldAddNewMultiClass::class)->setClasses($types);
        $gridfield->getConfig()->addComponent(new GridFieldShowHideAction());
        if ($this->owner->getArea()->getOwnerPage() && $this->owner->getArea()->getOwnerPage()->ClassName == "ParentBlock" && $this->owner->getArea()->getOwnerPage()->CollapsableChildren){
            $gridfield->getConfig()->addComponent(new GridFieldCollapseUncollapseAction());
        }
        $gridfield->getConfig()->addComponent(new GridFieldDuplicateBlock('before'));
        $gridfield->getConfig()->removeComponentsByType(GridFieldDeleteAction::class)
            ->addComponent(new GridFieldLinkBlock('before'))
            ->addComponent(new ElementalGridFieldDeleteAction());

        if ($gridfield->name == "Elements"){
            $gridfield->getConfig()->addComponent(new GridFieldBlockOrderAction());
        }

        $this->owner->extend('updateField', $gridField);
    }
   

}