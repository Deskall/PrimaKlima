<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;

use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;

class SitemapBlock extends BaseElement
{
    private static $inline_editable = false;
    
    private static $icon = 'font-icon-sitemap';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText'
    ];

   
    private static $table_name = 'SitemapBlock';

    private static $singular_name = 'Sitemap block';

    private static $plural_name = 'Sitemap blocks';

    private static $description = 'Allen Seiten im geordnete List';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('CallToActionLink');
            $fields->removeByName('Layout');
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));

        });
        return parent::getCMSFields();
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Sitemap');
    }


    public function SitemapItems() {
        $Pages = SiteTree::get()->filter(array(
            'ParentID' => 0,
            'ShowInSearch' => 1
        ))->exclude('ClassName','SilverStripe\ErrorPage\ErrorPage');
        return $Pages;
    }

}
