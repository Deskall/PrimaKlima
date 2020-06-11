<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\LabelField;
use SilverStripe\CMS\Model\SiteTree;
use DNADesign\Elemental\Models\BaseElement;
use Sheadawson\DependentDropdown\Forms\DependentDropdownField;

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
        $fields->addFieldToTab('Root.Main',
            DependentDropdownField::create('BlockID', _t(__CLASS__.'.Block','Block von dieser Seite'), $this->getBlockTree())->setDepends('SiteTreeID')
            ->displayIf('Type')->isEqualTo('SiteTree')->end()
        );
    }

    protected function getBlockTree($pageid){
        $blockstree = array(0 => _t(__CLASS__.'.Label','bestehende Block kopieren'));
        $page = SiteTree::get()->byId($pageid);
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