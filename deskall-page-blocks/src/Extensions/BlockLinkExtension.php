<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LabelField;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Models\BaseElement;

class BlockLinkExtension extends DataExtension
{

    private static $has_one = [
        'Block' => BaseElement::class
    ];


    function updateFieldLabels(&$labels) {
        $labels['Block'] = _t(__CLASS__.'.Block', 'Block von dieser Seite');
    }


    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('BlockID');
        if ($this->owner->ID > 0){
            $blocks = $this->owner->getBlockTree();
            $fields->insertAfter('SiteTreeID',DropdownField::create('BlockID',_t(__CLASS__.'.Block','Block von dieser Seite'),$blocks)->displayIf('Type')->isEqualTo('SiteTree')->end());
        }
        $fields->insertAfter('SiteTreeID',LabelField::create('Block',_t(__CLASS__.'.Block','Block von dieser Seite (bitte zuerst Seite Wählen und speichern)'))->displayIf('Type')->isEqualTo('SiteTree')->end());
    }

    protected function getBlockTree(){
        $blockstree = array(0 => _t(__CLASS__.'.Label','bestehende Block kopieren'));
        $page = $this->owner->SiteTree();
        if ($page->exists()){
            if ($page->ElementalAreaID > 0){
                foreach ($page->ElementalArea()->Elements() as $block) {
                    $blockstree[$block->ID] = $block->singleton($block->ClassName)->getType(). " > ".$block->NiceTitle();
                    if ($block->ClassName == "ParentBlock"){
                        foreach ($block->Elements()->Elements() as $underblock) {
                        $blockstree[$underblock->ID] = "  ".$block->NiceTitle(). " > ".$underblock->singleton($underblock->ClassName)->getType(). " > ".$underblock->NiceTitle();
                        }
                    }
                }
            }
        }
            
        return $blockstree;
    }
}