<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\Tab;
use SilverStripe\Core\Config\Config;
use SilverStripe\i18n\i18nEntityProvider;
use SilverStripe\Security\Permission;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use SilverStripe\Forms\TextField;

class BaseBlockExtension extends DataExtension implements i18nEntityProvider
{

    private static $db = [
        'TitleIcon' => 'Varchar',
        'isPrimary' => 'Boolean(0)',
        'FullWidth' => 'Boolean(0)',
        'Background' => 'Varchar(255)',
        'Layout' => 'Varchar(255)',
        'TitleAlign' => 'Varchar(255)',
        'TextAlign' => 'Varchar(255)',
        'TextColumns' => 'Varchar(255)',
        'TextColumnsDivider' => 'Boolean(0)',
        'Width' => 'Varchar'
    ];


    private static $has_one = [
        'BackgroundImage' => Image::class,
    ];

    private static $owns =[
        'BackgroundImage'
    ];

    private static $defaults = [
        'ShowTitle' => 1,
        'Background' => 'uk-section-default',
        'TextAlign' => 'uk-text-left',
        'TitleAlign' => 'uk-text-left',
        'TextColumns' => '1',
        'AvailableGlobally' => 1
    ];

    private static $blocks = [
        'TextBlock',
        'SliderBlock',
        'GalleryBlock',
        'BoxBlock',
        'FeaturesBlock',
        'ListBlock',
        'DNADesign-ElementalUserForms-Model-ElementForm',
        'DownloadBlock',
        'LargeImageBlock',
        'ParentBlock',
        'LeadBlock',
        'NavigationBlock',
        'MapBlock',
        'VideoBlock',
        'ActionBlock',
        'ShareBlock',
        'SitemapBlock',
        'CodeBlock',
        'DuplicateBlock',
        'VirtualBlock'
    ];

    private static $children_blocks = [
        'TextBlock',
        'SliderBlock',
        'GalleryBlock',
        'BoxBlock',
        'FeaturesBlock',
        'ListBlock',
        'DNADesign-ElementalUserForms-Model-ElementForm',
        'DownloadBlock',
        'ParentBlock',
        'MapBlock',
        'VideoBlock',
        'ActionBlock',
        'ShareBlock',
        'SitemapBlock',
        'DuplicateBlock',
        'VirtualBlock'
    ];

    private static $collapsable_blocks = [
        'TextBlock',  
        'GalleryBlock',
        'BoxBlock',
        'ListBlock',
        'DownloadBlock',
    ];

    private static $icon;

    private static $block_text_alignments = [
        'uk-text-left' =>  [
            'value' => 'uk-text-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'uk-text-right' => [
            'value' => 'uk-text-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-right-align.svg'
        ],
        'uk-text-center' =>  [
            'value' => 'uk-text-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-center-align.svg'
        ],
        'uk-text-justify' =>  [
            'value' => 'uk-text-justify',
            'title' => 'Justify Ausrichtung',
            'icon' => '/deskall-page-blocks/images/icon-text-justify-align.svg'
        ]
    ];



    private static $block_text_columns = [
        '1' =>  [
            'value' => '1',
            'title' => '1 Spalte',
            'icon' => '/deskall-page-blocks/images/icon-text.svg'
        ],
        'uk-column-1-2@s' =>  [
            'value' => 'uk-column-1-2@s',
            'title' => '2 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-2-columns.svg'
        ],
        'uk-column-1-2@s uk-column-1-3@m' =>  [
            'value' => 'uk-column-1-2@s uk-column-1-3@m',
            'title' => '3 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-3-columns.svg'
        ],
        'uk-column-1-2@s uk-column-1-4@m' =>  [
            'value' => 'uk-column-1-2@s uk-column-1-4@m',
            'title' => '4 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-4-columns.svg'
        ],
        'uk-column-1-2@s uk-column-1-4@m uk-column-1-5@l' =>  [
            'value' => 'uk-column-1-2@s uk-column-1-4@m uk-column-1-5@l',
            'title' => '5 Spalten',
            'icon' => '/deskall-page-blocks/images/icon-text-5-columns.svg'
        ]
    ];

    public function populateDefaults(){
        parent::populateDefaults();
        if ($this->owner->isPrimary){
            $this->owner->ShowTitle = 1;
        }
    }


    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('Background');
        $fields->removeByName('BackgroundImage');
        $fields->removeByName('FullWidth');
        $fields->removeByName('TextAlign');
        $fields->removeByName('TitleAlign');
        $fields->removeByName('TextColumns');
        $fields->removeByName('TextColumnsDivider');
        $fields->removeByName('AvailableGlobally');
       $fields->removeByName('Width');

        $extracss = $fields->fieldByName('Root.Settings.ExtraClass');
        $fields->removeByName('Settings');
        $fields->removeByName('ExtraClass');

        $fields->addFieldToTab('Root.Main',CheckboxField::create('isPrimary',_t(__CLASS__.".isPrimary","Ce bloc contient le titre principale de la page (h1)")),'TitleAndDisplayed');
        $fields->addFieldToTab('Root.Main',TextField::create('TitleIcon',_t(__CLASS__.".TitleIcon","Icone apposée au titre (class css font awesome)")),'TitleAndDisplayed');
      
     
        if (Permission::check('ADMIN') && $extracss){
            $fields->addFieldToTab('Root.LayoutTab',$extracss);
        } 
    	$fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            CheckboxField::create('FullWidth',_t(__CLASS__.'.FullWidth','volle Breite')),
            HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->setDescription(_t(__CLASS__.'.BackgroundColorHelpText','wird als overlay anzeigen falls es ein Hintergrundbild gibt.'))->addExtraClass('colors'),
            UploadField::create('BackgroundImage',_t(__CLASS__.'.BackgroundImage','Hintergrundbild'))->setFolderName($this->owner->getFolderName())
        )->setTitle(_t(__CLASS__.'.GlobalLayout','allgemeine Optionen'))->setName('GlobalLayout'));
        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            HTMLOptionsetField::create('TitleAlign',_t(__CLASS__.'.TitleAlignment','Titelausrichtung'),$this->owner->stat('block_text_alignments')),
            HTMLOptionsetField::create('TextAlign',_t(__CLASS__.'.TextAlignment','Textausrichtung'),$this->owner->stat('block_text_alignments')),
            HTMLOptionsetField::create('TextColumns',_t(__CLASS__.'.TextColumns','Text in mehreren Spalten'),$this->owner->stat('block_text_columns')),
            $columnDivider = CheckboxField::create('TextColumnsDivider',_t(__CLASS__.'.ShowColumnsBorder','Border zwischen Spalten anzeigen'))
        )->setTitle(_t(__CLASS__.'.TextLayout','Text Optionen'))->setName('TextLayout'));
        
        $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.ContentTab','Inhalt'));
        if ($history = $fields->FieldByName('Root.History') ){
            $fields->removeByName('History');
            $history->setTitle(_t(__CLASS__.'.HistoryTab','Versionen'));
            $fields->addFieldToTab('Root',$history);
        }


        $fields->FieldByName('Root.LayoutTab')->setTitle(_t(__CLASS__.'.LAYOUTTAB','Layout'));
    
 
        if ($this->owner->isPrimary){
            $fields->removeByName('TitleAndDisplayed');
        }

        if ($this->owner->isChildren()){
            $fields->FieldByName('Root.LayoutTab.GlobalLayout')->push(DropdownField::create('Width',_t('LayoutBlock.Width','Breite'),$this->owner->getTranslatedSourceFor('LayoutBlock','widths'))->setEmptyString(_t('LayoutBlock.WidthLabel','Breite auswählen'))->setDescription(_t('LayoutBlock.WidthDescription','Relative Breite im Vergleich zur Fußzeile')));
        }
        

    }

    public function getAnchorTitle(){
        return $this->owner->Title;
    }

    public function getFolderName(){

        $parent = $this->owner->Parent()->getOwnerPage();
       
        while(!$parent->hasMethod('generateFolderName')){
            $parent = $parent->Parent()->getOwnerPage();
        }
        return $parent->generateFolderName();
    }

    public function onBeforeWrite(){
        if (!$this->owner->Sort){
            $last = $this->owner->Parent()->Elements()->sort('Sort','DESC')->first();
            $this->owner->Sort = ($last) ? $last->Sort + 1 : 1;
        }
        if ($this->owner->isPrimary && $this->owner->getPage()){
            foreach($this->owner->getPage()->ElementalArea()->Elements()->filter('isPrimary',1)->exclude('ID',$this->owner->ID) as $primary){
                $primary->isPrimary = 0;
                $primary->write();
            }
        }
        parent::onBeforeWrite();
    }

    public function isChildren(){
        return $this->owner->Parent()->OwnerClassName == "ParentBlock";
    }

    public function isFirst(){
        if ($this->owner->isChildren()){
            return $this->owner->ID == $this->owner->Parent()->getOwnerPage()->Elements()->Elements()->first()->ID;
        }
        return false;
    }

    public function NiceTitle(){
        return ($this->owner->Title) ? $this->owner->Title : $this->owner->ID;
    }


   

    public function isFirstMobile(){
        if ($this->owner->isChildren()){
            return $this->owner->ID == $this->owner->Parent()->getOwnerPage()->FirstBlockID;
        }
        return false;
    }


    public function getHTMLOption(){
        $html = '<div class="option-html">
        <i class="'.$this->owner->config()->get('icon').'"></i>
        <strong>'.$this->owner->getType().'</strong>
        <p>'._t($this->owner->ClassName.'.Description',$this->owner->config()->get('description')).'</p>
      </div>';
        return $html;
    }

    public function AltTag($description, $name, $fallback = null){
        $text = ($description) ? $description : (($fallback) ? $fallback : $name);
        $text = strip_tags(preg_replace( "/\r|\n/", "", $text ));       
        return $text;
    }

    public function TitleTag($name,$fallback = null){
        $title = ($fallback) ? $fallback : $name;
        
        return $title;
    }

    public function HeightForWidth($width, $ImageWidth, $ImageHeight){
        return round($width / ($ImageWidth / $ImageHeight) , 0);
    }





    public function onAfterPublish(){
        if ($this->owner->hasMethod('Parent')){
            $this->owner->Parent()->publishSingle();
        }
        $this->owner->getPage()->publishSingle();
    }




/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        return $entities;
    }

/************* END TRANLSATIONS *******************/

}