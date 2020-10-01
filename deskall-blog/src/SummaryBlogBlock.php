<?php


use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Blog\Model\BlogPost;

class SummaryBlogBlock extends BaseElement
{
    private static $icon = 'font-icon-paper';

    private static $inline_editable = false;
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText'
    ];



    private static $defaults = [

    ];




    private static $table_name = 'SummaryBlogBlock';

    private static $singular_name = 'Blog Summary';

    private static $plural_name = 'Blog Summaries';

    private static $description = 'Letzte 3 Blog Artikeln';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Layout');
        
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Letzte 3 Blog Artikeln');
    }


    public function LastPosts(){
        return BlogPost::get()->limit(3);
    }

}
