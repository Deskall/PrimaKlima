<?php


use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class SummaryBlogBlock extends BaseElement
{
    private static $icon = 'font-icon-news';

    private static $inline_editable = false;
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText'
    ];

    private static $many_many = [
        'Articles' => BlogPost::class
    ];

    private static $many_many_extraFields = [
        'Articles' => ['SortOrder' => 'Int']
    ];


    private static $table_name = 'SummaryBlogBlock';

    private static $singular_name = 'Blog Summary';

    private static $plural_name = 'Blog Summaries';

    private static $description = 'Letzte 3 Blog Artikeln';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Layout');
        $fields->removeByName('Articles');
        if ($this->ID > 0){
            $fields->addFieldToTab('Root.Main',
                GridField::create(
                    'Articles',
                    'Blog-Artikel',
                    $this->Articles(),
                    GridFieldConfig_RelationEditor::create()
                        ->addComponent(new GridFieldOrderableRows('SortOrder'))
                )
            );
        }
        
        return $fields;
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Letzte 3 Blog Artikeln');
    }

    public function getPosts(){
        return ($this->Articles()->exists()) ? $this->Articles() : $this->LastPosts();
    }


    public function LastPosts(){
        return BlogPost::get()->limit(3);
    }

}
