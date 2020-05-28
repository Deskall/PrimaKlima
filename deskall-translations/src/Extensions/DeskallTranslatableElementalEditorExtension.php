<?php

use SilverStripe\ORM\DataExtension;
use Symbiote\GridFieldExtensions\GridFieldAddNewMultiClass;
use DNADesign\ElementalVirtual\Forms\ElementalGridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;

class DeskallTranslatableElementalEditorExtension extends DataExtension 
{
   
	//To finish
    public function updateField($gridfield){
    	// $gridfield->getConfig()
     //    ->addComponent(new GridFieldDeleteInAllLocalesAction());
    }
   

}