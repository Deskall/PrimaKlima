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
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\ORM\DataObject;
use SilverStripe\Core\ClassInfo;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Forms\TextareaField;
use Sheadawson\Linkable\Models\Link;

class BaseBlockExtension extends DataExtension implements i18nEntityProvider
{

    private static $db = [
        'isPrimary' => 'Boolean(0)',
        'FullWidth' => 'Boolean(0)',
        'Background' => 'Varchar(255)',
        'Layout' => 'Varchar(255)',
        'TitleAlign' => 'Varchar(255)',
        'TextAlign' => 'Varchar(255)',
        'TextColumns' => 'Varchar(255)',
        'TextColumnsDivider' => 'Boolean(0)',
        'Width' => 'Varchar',
        'Animation' => 'Varchar',
        'BackgroundImageEffect' => 'Boolean(0)',
        'SectionPadding' => 'Varchar',
        'AnchorTitle' => 'Varchar'
    ];


    private static $has_one = [
        'BackgroundImage' => Image::class,
    ];

    private static $has_many = [
        'Links' => Link::class,
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
        'AvailableGlobally' => 1,
        'SectionPadding' => 'uk-section-small'
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

    private static $collapsable_blocks = [
        'TextBlock',  
        'GalleryBlock',
        'BoxBlock',
        'ListBlock',
        'DownloadBlock',
        'ParentBlock'
    ];

    private static $icon;

    private static $block_text_alignments = [
        'uk-text-left' =>  [
            'value' => 'uk-text-left',
            'title' => 'Links Ausrichtung',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-left-align.svg'
        ],
        'uk-text-right' => [
            'value' => 'uk-text-right',
            'title' => 'Rechts Ausrichtung',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-right-align.svg'
        ],
        'uk-text-center' =>  [
            'value' => 'uk-text-center',
            'title' => 'Mittel Ausrichtung',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-center-align.svg'
        ],
        'uk-text-justify@s' =>  [
            'value' => 'uk-text-justify@s',
            'title' => 'Justify Ausrichtung',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-justify-align.svg'
        ]
    ];

   


    private static $block_text_columns = [
        '1' =>  [
            'value' => '1',
            'title' => '1 Spalte',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text.svg'
        ],
        'uk-column-1-2@s' =>  [
            'value' => 'uk-column-1-2@s',
            'title' => '2 Spalten',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-2-columns.svg'
        ],
        'uk-column-1-2@s uk-column-1-3@m' =>  [
            'value' => 'uk-column-1-2@s uk-column-1-3@m',
            'title' => '3 Spalten',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-3-columns.svg'
        ],
        'uk-column-1-2@s uk-column-1-4@m' =>  [
            'value' => 'uk-column-1-2@s uk-column-1-4@m',
            'title' => '4 Spalten',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-4-columns.svg'
        ],
        'uk-column-1-2@s uk-column-1-4@m uk-column-1-5@l' =>  [
            'value' => 'uk-column-1-2@s uk-column-1-4@m uk-column-1-5@l',
            'title' => '5 Spalten',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-5-columns.svg'
        ]
    ];

    public function populateDefaults(){
        parent::populateDefaults();
        if ($this->owner->isPrimary){
            $this->owner->ShowTitle = 1;
        }
        //determine width if not set
        if (!$this->owner->isChildren() ){
            $this->owner->Width = 'uk-width-1-1';
        }
       
    }

    public function updateFieldLabels(&$labels){
        $labels['AnchorTitle'] = 'Anker';
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
        $fields->removeByName('Animation');
        $fields->removeByName('BackgroundImageEffect');
        $fields->removeByName('SectionPadding');

        $extracss = $fields->fieldByName('Root.Settings.ExtraClass');
        $fields->removeByName('Settings');
        $fields->removeByName('ExtraClass');
        $fields->replaceField('Title',TextareaField::create('Title',$this->owner->fieldLabel('Title'))->setRows(2));
        $fields->addFieldToTab('Root.Main',CheckboxField::create('isPrimary',_t(__CLASS__.".isPrimary","Diese Block enthalt den Haupttitel der Seite (h1)")),'TitleAndDisplayed');
      
     
        if (Permission::check('ADMIN') && $extracss){
            $fields->addFieldToTab('Root.LayoutTab',$extracss);
        } 
        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            CheckboxField::create('FullWidth',_t(__CLASS__.'.FullWidth','volle Breite')),
            DropdownField::create('SectionPadding',_t(__CLASS__.'.SectionPadding','Vertical Abstand'),['uk-padding-remove' => 'Keine','uk-section-small' => 'klein', 'uk-section-medium' => 'medium','uk-section-large' => 'gross']),
            HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->setDescription(_t(__CLASS__.'.BackgroundColorHelpText','wird als overlay anzeigen falls es ein Hintergrundbild gibt.'))->addExtraClass('colors'),
            UploadField::create('BackgroundImage',_t(__CLASS__.'.BackgroundImage','Hintergrundbild'))->setFolderName($this->owner->getFolderName()),
            CheckboxField::create('BackgroundImageEffect',_t(__CLASS__.'.BackgroundImageEffect','Behobenes Scrollen des Bildes?')),
            TextField::create('Animation',_t(__CLASS__.'.Animation','Animation'))
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

        //if ($this->owner->isChildren()){
            $fields->FieldByName('Root.LayoutTab.GlobalLayout')->push(DropdownField::create('Width',_t('LayoutBlock.Width','Breite'),$this->owner->getTranslatedSourceFor('LayoutBlock','widths'))->setEmptyString(_t('Block.WidthLabel','Standard Breite (nimmt einfach die Seite Layout Parameter)'))->setDescription(_t('LayoutBlock.WidthDescription','Relative Breite im Vergleich zur Fußzeile')));
      //  }
        

    }

    public function generateAnchorTitle()
    {

        $anchorTitle = '';

        if (!$this->owner->config()->disable_pretty_anchor_name) {
            if ($this->owner->hasMethod('getAnchorTitle')) {
                $anchorTitle = $this->owner->getAnchorTitle();
            } elseif ($this->owner->config()->enable_title_in_template) {
                $anchorTitle = $this->owner->getField('Title');
            }
        }

        if (!$anchorTitle) {
            $anchorTitle = ($this->owner->Title) ? $this->owner->Title : $this->owner->ClassName.'-'.$this->owner->ID;
        }

        $filter = URLSegmentFilter::create();
        $titleAsURL = $filter->filter($anchorTitle);

        // Ensure that this anchor name isn't already in use
        // ie. If two elemental blocks have the same title, it'll append '-2', '-3'
        $result = $titleAsURL;
        $count = 1;
        while (BaseElement::get()->filter('AnchorTitle',$result)->exists()) {
            ++$count;
            $result = $titleAsURL . '-' . $count;
        }
       
        return $this->owner->anchor = $result;
    }

    public function getFolderName(){

        $parent = $this->owner->Parent();
        if ($parent && $parent->getOwnerPage()){
            $page = $parent->getOwnerPage();
       
            while(!$page->hasMethod('generateFolderName')){
                $page = $page->Parent()->getOwnerPage();
            }
            return $page->generateFolderName();
        }
        return null;
    }

    public function onBeforeWrite(){
        if (!$this->owner->Sort){
            $last = $this->owner->Parent()->Elements()->sort('Sort','DESC')->first();
            $this->owner->Sort = ($last) ? $last->Sort + 1 : 1;
        }
        if (!$this->owner->AnchorTitle){
            $this->owner->AnchorTitle = $this->generateAnchorTitle();
        }
        if ($this->owner->isPrimary){
            foreach(BaseElement::get()->filter('isPrimary',1)->exclude('ID',$this->owner->ID) as $primary){
                if ($primary->getRealPage() && $this->owner->getRealPage() && $primary->getRealPage()->ID == $this->owner->getRealPage()->ID){
                    $primary->isPrimary = 0;
                    $primary->write();
                }
            }
        }

        parent::onBeforeWrite();
    }

    public function getRealPage(){
        $parent = null;
        if (ClassInfo::exists($this->owner->Parent()->OwnerClassName)){
            $parent = $this->owner->getPage();
            while($parent && !in_array('SilverStripe\CMS\Model\SiteTree',$parent->getClassAncestry())){
                $parent = $parent->getPage();
            }
        }
        return $parent;
    }

   public function updateLink(&$link){
        if ($page = $this->owner->getRealPage()) {
            $link = substr($link,0,strpos($link,'#'));
            $link = $link . '#' . $this->owner->AnchorTitle;
        }
    }


    public function isChildren(){
        return $this->owner->Parent()->OwnerClassName == "ParentBlock";
    }

    public function isFirst(){
        if ($this->owner->Parent()->getOwnerPage() && $this->owner->isChildren()){
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
        // $title = ($fallback) ? $fallback : $name;
        
        // return $title;
        return "Klicken, um das Bild zu vergrößern";
    }

    public function HeightForWidth($width, $ImageWidth, $ImageHeight){
        return round($width / ($ImageWidth / $ImageHeight) , 0);
    }





    // public function onAfterPublish(){
    //     if ($this->owner->hasMethod('Parent')){
    //         $this->owner->Parent()->publishSingle();
    //     }
    //     if ($this->owner->getPage()){
    //         $this->owner->getPage()->publishSingle();
    //     }
    // }




/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        return $entities;
    }

/************* END TRANLSATIONS *******************/

}