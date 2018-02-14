<?php

use SilverStripe\ORM\DataExtension;


class ElementalEditorExtension extends DataExtension 
{
    public function updateGetTypes($types){

    }

     public function updateField($gridfield){
        $gridfield->getConfig()->addComponent(new GridFieldShowHideAction());
    }
   

}