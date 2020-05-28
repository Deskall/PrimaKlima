<?php

use SilverStripe\ORM\DataExtension;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use DNADesign\ElementalVirtual\Forms\ElementalGridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;

class DeskallTranslatableElementalEditorExtension extends DataExtension 
{
   

     public function updateField($gridfield){
     	$types = $this->owner->getTypes();
        
    	$gridfield->getConfig()
        ->addComponent(new GridFieldDeleteInAllLocalesAction());

        $this->owner->extend('updateField', $gridField);
    }
   

}