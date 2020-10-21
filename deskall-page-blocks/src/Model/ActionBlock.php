<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use UncleCheese\DisplayLogic\Forms\Wrapper;
use g4b0\SearchableDataObjects\Searchable;

class ActionBlock extends BaseElement implements Searchable
{
    private static $inline_editable = false;
    
    private static $icon = 'font-icon-plus-circled';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $table_name = 'ActionBlock';

    private static $singular_name = 'Action block';

    private static $plural_name = 'Action blocks';

    private static $description = 'Aktion, die ein Ereignis auslöst (Fenster, Dropdown,...)';


    private static $db = [
        'Trigger' => 'Varchar(255)',
        'InteractionType' => 'Varchar(255)',
        'HTML' => 'HTMLText',
        'ActionHTML' => 'HTMLText',
        'CloseText' => 'Varchar(255)',
        'ModalSize' => 'Varchar(255)',
        'ModalScroll' => 'Boolean(0)',
        'ButtonBackground' => 'Varchar(255)',
        'ButtonPosition' => 'Varchar(255)',
        'DropdownTrigger' => 'Varchar(255)',
        'Target' => 'Varchar(255)',
        'ToggleClass' => 'Varchar(255)',
        'DropdownPosition' => 'Varchar(255)',
        'Effect' => 'Varchar(255)',
        'OffcanvasOverlay' => 'Boolean(0)',
        'OffcanvasPosition' => 'Varchar(255)',
        'DropdownPosition' => 'Varchar(255)',
        'DropdownBoundary' => 'Boolean(0)'
    ];

    private static $has_one = [
        'ContentImage' => Image::class
    ];

    private static $owns = [
        'ContentImage',
    ];

    private static $defaults = [
        'Layout' => 'left'
    ];

    private static $block_actions = [
       'modal' => 'Modal',
       'dropdown' => 'Dropdown',
       'offcanvas' => 'Offcanvas',
       'toggle' => 'Toggle',
       'scroll' => 'Scroll'
    ];

    private static $cascade_duplicates = [];


    private static $modal_sizes = [
       'auto' => 'Breite des Inhalt',
       'uk-modal-container' => 'Breite der Seite',
       'uk-modal-full' => 'Voll Breite'
    ];

    private static $dropdown_positions = [
        'bottom-left' => 'Aligns the dropdown to the bottom left',
        'bottom-center'  => 'Aligns the dropdown to the bottom center',
        'bottom-right'   => 'Aligns the dropdown to the bottom right',
        'bottom-justify' => 'Aligns the dropdown to the bottom and justifies its width to the related element',
        'top-left'   => 'Aligns the dropdown to the top left',
        'top-center' => 'Aligns the dropdown to the top center',
        'top-right'  => 'Aligns the dropdown to the top right',
        'top-justify' => 'Aligns the dropdown to the top and justifies its width to the related element',
        'left-top'   => 'Aligns the dropdown to the left top',
        'left-center' => 'Aligns the dropdown to the left center',
        'left-bottom' => 'Aligns the dropdown to the left bottom',
        'right-top' => 'Aligns the dropdown to the right top',
        'right-center'   => 'Aligns the dropdown to the right center',
        'right-bottom'   => 'Aligns the dropdown to the right bottom'
    ];

    private static $dropdown_triggers = [
        'hover' => 'Hover',
        'click'  => 'Klick',
        'hover,click'   => 'Hover und Klick'
    ];

    private static $offcanvas_position = [
        'left' =>  'Links',
        'right' => 'Rechts'
    ];


    private static $block_effects = [
        'slide' => 'Slide',
        'reveal' => 'Reveal',
        'push' => 'Push', 
        'none' => 'None'
    ];

    private static $button_alignments = [
        'left' =>  'Links',
        'center' =>  'Mittel',
        'right' => 'Rechts'
    ];

    private static $button_backgrounds = [
        'uk-button-default' => 'keine Hintergrundfarbe',
        'uk-button-primary dk-text-hover-primary' => 'primäre Farbe',
        'uk-button-secondary dk-text-hover-secondary' => 'sekundäre Farbe',
        'uk-button-muted dk-text-hover-muted' => 'grau',
        'dk-background-white uk-section-default dk-text-hover-white' => 'weiss',
        'dk-background-black uk-section-default dk-text-hover-black' => 'schwarz'
    ];



/***********************************************************************/
    
    public function fieldLabels($includerelations = true ){
        $labels = parent::fieldLabels($includerelations );
        $labels['Trigger'] = _t(__CLASS__.'.TriggeringText', 'Text der Öffnen-Button');
        $labels['CloseText'] = _t(__CLASS__.'.CloseText', 'Text der Schließen-Button');
        $labels['ActionHTML'] = _t(__CLASS__.'.ActionHTML', 'Inhalt der Modal / Off-Canvas / Dropdown ...');

        return $labels;
    }
    

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('FullWidth');
        $fields->removeByName('BackgroundImage');
        $fields->removeByName('ButtonBackground');
        $fields->removeByName('ButtonPosition');
        $fields->removeByName('ModalSize');
        $fields->removeByName('OffcanvasOverlay');
        $fields->removeByName('DropdownPosition');
        $fields->removeByName('DropdownBoundary');
        $fields->removeByName('DropdownTrigger');
        $fields->removeByName('OffcanvasPosition');
        $fields->removeByName('Effect');
        $fields->removeByName('ModalScroll');
        $fields->removeByName('Target');
        $fields->removeByName('Layout');
        //$title = $fields->fieldByName('Root.Main.TitleAndDisplayed');
      //  $fields->removeByName('TitleAndDisplayed');

        $fields->fieldByName('Root.Main.HTML')->setTitle(_t(__CLASS__ . '.ContentLabel', 'Inhalt'))->setRows(5);
        $fields->fieldByName('Root.Main.ContentImage')->setFolderName($this->getFolderName());
       // $fields->addFieldToTab('Root.Main',Wrapper::create($title)->displayIf('InteractionType')->isEqualTo('modal')->orIf('InteractionType')->isEqualTo('offcanvas')->orIf('InteractionType')->isEqualTo('dropdown')->end());
        $fields->addFieldToTab('Root.Main',DropdownField::create('InteractionType',_t(__CLASS__.'.InteractionType','Typ'), $this->getTranslatedSourceFor(__CLASS__,'block_actions'))->setEmptyString(_t(__CLASS__.'.InteractionTypeHelp','Bitte Typ auswählen')),'TitleAndDisplayed');
        $fields->insertAfter('InteractionType',$fields->fieldByName('Root.Main.Trigger'));
        $fields->insertAfter('Trigger',$fields->fieldByName('Root.Main.CloseText'));
        $fields->addFieldToTab('Root.Main',DropdownField::create('Target',_t(__CLASS__.'.Target','Zielelement'), $this->getPageElements())->setEmptyString(_t(__CLASS__.'.TargetHelp','Bitte Element auswählen')));
            
        //MODALS LAYOUT
        $fields->addFieldToTab('Root.LayoutTab',Wrapper::create(CompositeField::create(
            DropdownField::create('ButtonBackground',_t(__CLASS__.'.ButtonBackground','Button Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'),
            DropdownField::create('ButtonPosition',_t(__CLASS__.'.ButtonPosition','Button Ausrichtung'), $this->getTranslatedSourceFor(__CLASS__,'button_alignments')),
            DropdownField::create('ModalSize',_t(__CLASS__.'.ModalSize','Fenster Breite'), $this->getTranslatedSourceFor(__CLASS__,'modal_sizes')),
            $fields->fieldByName('Root.Main.ModalScroll')
        )->setTitle(_t(__CLASS__.'.ModalLayout','Modal Format'))->setName('ModalLayout')));

        //DROPDOWNS LAYOUT
        $fields->addFieldToTab('Root.LayoutTab',Wrapper::create(CompositeField::create(
            DropdownField::create('DropdownPosition',_t(__CLASS__.'.DropdownPosition','Dropdown Ausrichtung'), $this->getTranslatedSourceFor(__CLASS__,'dropdown_positions')),
            DropdownField::create('DropdownTrigger',_t(__CLASS__.'.DropdownTrigger','Ereignis auslöst an'), $this->getTranslatedSourceFor(__CLASS__,'dropdown_triggers')),
            CheckboxField::create('DropdownBoundary',_t(__CLASS__.'.DropdownBoundary','Inhalt auf Elternteil beschränken'))
        )->setTitle(_t(__CLASS__.'.DropdownLayout','Dropdown Format'))->setName('DropdownLayout')));

        //OFFCANVAS LAYOUT
        $fields->addFieldToTab('Root.LayoutTab',Wrapper::create(CompositeField::create(
            DropdownField::create('OffcanvasPosition',_t(__CLASS__.'.OffcanvasPosition','Offcanvas Position'), $this->getTranslatedSourceFor(__CLASS__,'offcanvas_position')),
            CheckboxField::create('OffcanvasOverlay',_t(__CLASS__.'.OffcanvasOverlay','Offcanvas Overlay')),
            DropdownField::create('Effect',_t(__CLASS__.'.OffcanvasEffect','Offcanvas Effekt'), $this->getTranslatedSourceFor(__CLASS__,'block_effects'))
        )->setTitle(_t(__CLASS__.'.OffcanvasLayout','Offcanvas Format'))->setName('OffcanvasLayout')));

        //Scroll et Toogle
        $fields->fieldByName('Root.Main.Target')->displayIf('InteractionType')->isEqualTo('scroll')->orIf('InteractionType')->isEqualTo('toggle');

        //Toggle
        $fields->fieldByName('Root.Main.ToggleClass')->displayIf('InteractionType')->isEqualTo('toggle');

        //Content Display Rules
        $fields->fieldByName('Root.Main.HTML')->hideIf('InteractionType')->isEqualTo('scroll');
        $fields->fieldByName('Root.Main.ActionHTML')->hideIf('InteractionType')->isEqualTo('scroll');
        $fields->fieldByName('Root.Main.LinkableLinkID')->hideIf('InteractionType')->isEqualTo('scroll');
        $fields->fieldByName('Root.Main.ContentImage')->hideIf('InteractionType')->isEqualTo('scroll');
        
      //  $fields->fieldByName('Root.Main.CloseText')->displayIf('InteractionType')->isEqualTo('modal')->orIf('InteractionType')->isEqualTo('offcanvas')->orIf('InteractionType')->isEqualTo('dropdown');

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Aktion');
    }

    public function getPageElements(){
        $parent = $this->Parent()->getOwnerPage();
        if ($parent) {
            while(!$parent->hasMethod('generateFolderName')){
                $parent = $parent->Parent()->getOwnerPage();
            }
            $blocks = $parent->ElementalArea()->Elements();
            return $blocks->map('ID','NiceTitle');
        }
        return [];
    }

    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_actions') as $key => $value) {
          $entities[__CLASS__.".block_actions_{$key}"] = $value;
        }
        foreach($this->stat('block_effects') as $key => $value) {
          $entities[__CLASS__.".block_effects_{$key}"] = $value;
        }
        foreach($this->stat('modal_sizes') as $key => $value) {
          $entities[__CLASS__.".modal_sizes_{$key}"] = $value;
        }
        foreach($this->stat('button_alignments') as $key => $value) {
          $entities[__CLASS__.".button_alignments_{$key}"] = $value;
        }
        foreach($this->stat('button_backgrounds') as $key => $value) {
          $entities[__CLASS__.".button_backgrounds_{$key}"] = $value;
        }
        foreach($this->stat('dropdown_positions') as $key => $value) {
          $entities[__CLASS__.".dropdown_positions_{$key}"] = $value;
        }
        foreach($this->stat('dropdown_triggers') as $key => $value) {
          $entities[__CLASS__.".dropdown_triggers_{$key}"] = $value;
        }
        foreach($this->stat('offcanvas_position') as $key => $value) {
          $entities[__CLASS__.".offcanvas_position_{$key}"] = $value;
        }
        
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/


/************* SEARCHABLE FUNCTIONS ******************/


    /**
     * Filter array
     * eg. array('Disabled' => 0);
     * @return array
     */
    public static function getSearchFilter() {
        return array();
    }

    /**
     * FilterAny array (optional)
     * eg. array('Disabled' => 0, 'Override' => 1);
     * @return array
     */
    public static function getSearchFilterAny() {
        return array();
    }


    /**
     * Fields that compose the Title
     * eg. array('Title', 'Subtitle');
     * @return array
     */
    public function getTitleFields() {
        return array('Title');
    }

    /**
     * Fields that compose the Content
     * eg. array('Teaser', 'Content');
     * @return array
     */
    public function getContentFields() {
        return array('HTML');
    }
/************ END SEARCHABLE ***************************/
}
