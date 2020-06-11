<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GroupedDropdownField;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Models\BaseElement;

class BlockLinkExtension extends DataExtension
{
    private static $types = ['block' => 'bestimmt Block von dieser Website']; 

    private static $has_one = [
        'Block' => BaseElement::class
    ];


    function updateFieldLabels(&$labels) {
        $labels['Block'] = _t(__CLASS__.'.Block', 'bestimmt Block von dieser Website');
    }


    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('BlockID');
        $blocks = $this->getBlockTree();
        $fields->addFieldToTab('Root.Main',GroupedDropdownField::create('BlockID',_t(__CLASS__.'.Block','Block von dieser Seite'),$blocks)->displayIf('Type')->isEqualTo('block')->end());
    }

    protected function getBlockTree(){
        $blockstree = array(0 => _t(__CLASS__.'.Label','Bitte Block wählen'));
        $Pages = Page::get()->sort('Sort ASC');
        foreach ($Pages as $page) {
            if ($page->ElementalAreaID > 0){
                $blocks = array();
                foreach ($page->ElementalArea()->Elements() as $block) {
                    
                    $blocks[$block->ID] = $block->singleton($block->ClassName)->getType(). " > ".$block->NiceTitle();
                    if ($block->ClassName == "ParentBlock"){
                        foreach ($block->Elements()->Elements() as $underblock) {
                        $blocks[$underblock->ID] = "  ".$block->NiceTitle(). " > ".$underblock->singleton($underblock->ClassName)->getType(). " > ".$underblock->NiceTitle();
                        }
                    }
                }
                //build the page unique sitetree strucuture
                $pageTree = $page->ID.' - '.$page->NestedTitle(4," > ");
            
                $blockstree[$pageTree] = $blocks;
            }
        }
        return $blockstree;
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        ob_start();
            print_r($this->owner);
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
    }

    public function onAfterWrite(){
        parent::onAfterWrite();
        if (!$this->owner->Title && $this->owner->Type == "block") {
            $this->owner->Title = $this->owner->Block()->Title;
        }
    }

    public function updateLinkURL($LinkURL){
        if ($this->owner->Type == "block"){
            $LinkURL = $this->owner->Block()->Link();
        }
    }
            
}