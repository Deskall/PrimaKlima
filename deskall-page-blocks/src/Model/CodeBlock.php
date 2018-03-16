<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;

use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;

class CodeBlock extends BaseElement
{
    private static $icon = 'font-icon-code';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'Script' => 'Text',
        'Position' => 'Varchar(255)'
    ];

   
    private static $table_name = 'CodeBlock';

    private static $singular_name = 'Code block';

    private static $plural_name = 'Code blocks';

    private static $description = 'Script wie Google Analytics oder Facebook hinzufügen.';

    private static $block_positions = [
        'head' => 'Im <head>',
        'body' => 'Vor dem </body> Tag',
        'normal' => 'Block Position'
    ];

    private static $defaults = ['Position' => 'head'];

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('CallToActionLink');
            $fields->removeByName('Layout');
            $fields->removeByName('TitleAndDisplayed');
            $fields->FieldByName('Root.Main.Script')->setDescription(_t(__CLASS__.'ScriptLabel','Bitte Kopieren Sie hier die Scripts ohne "<></>" tags'));
            $fields->addFieldToTab('Root.Main',DropdownField::create('Position',_t(__CLASS__.'ScriptPosition','Script Position'), $this->getTranslatedSourceFor(__CLASS__,'block_positions')));

        });
        return parent::getCMSFields();
    }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if ($this->Position != "normal"){
             $this->isVisible = 0;
        }
       
    }


    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Code - Plugin');
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_positions') as $key => $value) {
          $entities[__CLASS__.".block_positions_{$key}"] = $value;
        }       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
