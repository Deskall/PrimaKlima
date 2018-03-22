<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use UncleCheese\DisplayLogic\Forms\Wrapper;

class ActionBlock extends BaseElement
{
    private static $icon = 'font-icon-link';
    
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
        'CloseText' => 'Varchar(255)',
        'ModalSize' => 'Varchar(255)',
        'ModalScroll' => 'Boolean(0)',
        'ButtonBackground' => 'Varchar(255)',
        'ButtonPosition' => 'Varchar(255)',
        'DropdownTrigger' => 'Varchar(255)',
        'Target' => 'Varchar(255)',
        'DropdownPosition' => 'Varchar(255)',
        'Effect' => 'Varchar(255)',
        'OffcanvasOverlay' => 'Boolean(0)',
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


    private static $block_layouts = [
        'left' => 'Links',
        'right' => 'Rechts',
        'hover' => 'Oben', 
        'above' => 'Unten'
    ];

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
        $labels['Trigger'] = _t(__CLASS__.'.TriggeringText', 'Text für das Button');
        $labels['CloseText'] = _t(__CLASS__.'.CloseText', 'Close button text');

        return $labels;
    }
    

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {

            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Inhalt'));
            $fields->fieldByName('Root.Main.ContentImage')->setFolderName($this->getFolderName());
           
             
        });
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main',DropdownField::create('InteractionType','Typ', $this->getTranslatedSourceFor(__CLASS__,'block_actions'))->setEmptyString('Bitte Typ auswählen'),'TitleAndDisplayed');
        $fields->insertAfter('InteractionType',$fields->fieldByName('Root.Main.Trigger'));
        $fields->removeByName('FullWidth');
        $fields->removeByName('BackgroundImage');
        $fields->removeByName('ButtonBackground');
        $fields->removeByName('ButtonPosition');
        $fields->removeByName('ModalSize');
        $fields->removeByName('OffcanvasOverlay');
        $fields->removeByName('DropdownPosition');
       $fields->removeByName('DropdownBoundary');
        $fields->removeByName('DropdownTrigger');
        //MODALS
        $fields->addFieldToTab('Root.Layout',LayoutField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')));
        $fields->addFieldToTab('Root.Layout',DropdownField::create('ButtonBackground',_t(__CLASS__.'.ButtonBackground','Button Farbe'), $this->getTranslatedSourceFor(__CLASS__,'button_backgrounds')));
            $fields->addFieldToTab('Root.Layout',DropdownField::create('ButtonPosition',_t(__CLASS__.'.ButtonPosition','Button Ausrichtung'), $this->getTranslatedSourceFor(__CLASS__,'button_alignments')));
            $fields->addFieldToTab('Root.Layout',DropdownField::create('ModalSize',_t(__CLASS__.'.ModalSize','Fenster Breite'), $this->getTranslatedSourceFor(__CLASS__,'modal_sizes')));
        //DROPDOWNS
        $fields->addFieldToTab('Root.Layout',DropdownField::create('DropdownPosition',_t(__CLASS__.'.DropdownPosition','Dropdown Ausrichtung'), $this->getTranslatedSourceFor(__CLASS__,'dropdown_positions')));
        $fields->addFieldToTab('Root.Layout',CheckboxField::create('DropdownBoundary',_t(__CLASS__.'.DropdownBoundary','Inhalt auf Elternteil beschränken')));
        //OFFCANVAS
        $fields->addFieldToTab('Root.Layout',CheckboxField::create('OffcanvasOverlay',_t(__CLASS__.'.OffcanvasOverlay','Offcanvas Overlay')));
        $fields->addFieldsToTab('Root.Settings',
            [
                DropdownField::create('DropdownTrigger',_t(__CLASS__.'.DropdownTrigger','Ereignis auslöst an'), $this->getTranslatedSourceFor(__CLASS__,'dropdown_triggers')),
                $fields->fieldByName('Root.Layout.DropdownPosition'),
                $fields->fieldByName('Root.Main.Target'),
                $fields->fieldByName('Root.Main.ModalScroll'),
                DropdownField::create('Effect',_t(__CLASS__.'.OffcanvasEffect','Offcanvas Effekt'), $this->getTranslatedSourceFor(__CLASS__,'block_effects'))
            ]
        );


        //Display Rules
        $fields->fieldByName('Root.Main.HTML')->displayIf('InteractionType')->isEqualTo('modal')->orIf('InteractionType')->isEqualTo('offcanvas')->orIf('InteractionType')->isEqualTo('dropdown');
        $fields->fieldByName('Root.Main.LinkableLinkID')->displayIf('InteractionType')->isEqualTo('modal')->orIf('InteractionType')->isEqualTo('offcanvas')->orIf('InteractionType')->isEqualTo('dropdown');
        $fields->fieldByName('Root.Main.ContentImage')->displayIf('InteractionType')->isEqualTo('modal')->orIf('InteractionType')->isEqualTo('offcanvas')->orIf('InteractionType')->isEqualTo('dropdown');
        $fields->fieldByName('Root.Layout.ButtonBackground')->displayIf('InteractionType')->isEqualTo('modal');
        $fields->fieldByName('Root.Layout.ButtonPosition')->displayIf('InteractionType')->isEqualTo('modal');
        $fields->fieldByName('Root.Main.CloseText')->displayIf('InteractionType')->isEqualTo('modal');
        $fields->fieldByName('Root.Layout.ModalSize')->displayIf('InteractionType')->isEqualTo('modal');
        $fields->fieldByName('Root.Settings.ModalScroll')->displayIf('InteractionType')->isEqualTo('modal');
        $fields->fieldByName('Root.Settings.DropdownTrigger')->displayIf('InteractionType')->isEqualTo('dropdown');
        $fields->fieldByName('Root.Settings.DropdownPosition')->displayIf('InteractionType')->isEqualTo('dropdown');
        $fields->fieldByName('Root.Settings.Target')->displayIf('InteractionType')->isEqualTo('dropdown');
        $fields->fieldByName('Root.Settings.Effect')->displayIf('InteractionType')->isEqualTo('offcanvas');
        $fields->fieldByName('Root.Layout.OffcanvasOverlay')->displayIf('InteractionType')->isEqualTo('offcanvas');


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

    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
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
        
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/
}
