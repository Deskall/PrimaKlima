<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\ORM\FieldType\DBField;

class HeaderSlide extends DataObject
{

    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText',
        'Effect' => 'Varchar(255)',
        'EffectOptions' => 'Varchar(255)',
        'TextPosition' => 'Varchar(255)',
        'TextBackground' => 'Varchar(255)',
        'TextWidth' => 'Varchar(255)',
        'TextOffset' => 'Varchar(255)',
        'TextOpacity' => 'Varchar(255)',
        'TitleAlign' => 'Varchar(255)',
        'TextAlign' => 'Varchar(255)',
        'TextColumns' => 'Varchar(255)',
        'TextColumnsDivider' => 'Boolean(0)',
        'Background' => 'Varchar(255)',
        'isMainSlide' => 'Boolean(0)'
    ];

    private static $has_one = [
        'Parent' => SiteConfig::class,
        'Image' => Image::class
    ];

    private static $defaults = [
        'TextAlign' => 'uk-text-left',
        'TitleAlign' => 'uk-text-left',
        'TextPosition' => 'uk-position-center'
    ];

    private static $block_text_positions = [
        '' =>  [
            'value' => '',
            'title' => 'Keine',
            'icon' => 'Keine'
        ],
        'uk-position-bottom-left' =>  [
            'value' => 'uk-position-bottom-left',
            'title' => 'Bottom left',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-bottom-left.svg'
        ],
        'uk-position-bottom-center' =>  [
            'value' => 'uk-position-bottom-center',
            'title' => 'Bottom center',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-bottom-center.svg'
        ],
        'uk-position-bottom-right' =>  [
            'value' => 'uk-position-bottom-right',
            'title' => 'Bottom right',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-bottom-right.svg'
        ],
        'uk-position-center-left' =>  [
            'value' => 'uk-position-center-left',
            'title' => 'Center left',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-center-left.svg'
        ],
        'uk-position-center' =>  [
            'value' => 'uk-position-center',
            'title' => 'Center',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-center.svg'
        ],
        'uk-position-center-right' =>  [
            'value' => 'uk-position-center-right',
            'title' => 'Center right',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-center-right.svg'
        ],
        'uk-position-top-left' =>  [
            'value' => 'uk-position-top-left',
            'title' => 'Top left',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-top-left.svg'
        ],
        'uk-position-top-center' =>  [
            'value' => 'uk-position-top-center',
            'title' => 'Top center',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-top-center.svg'
        ],
        'uk-position-top-right' =>  [
            'value' => 'uk-position-top-right',
            'title' => 'Top right',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-top-right.svg'
        ]
       
       
    ];

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
        'uk-text-justify' =>  [
            'value' => 'uk-text-justify',
            'title' => 'Justify Ausrichtung',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-justify-align.svg'
        ]
    ];

    private static $block_text_widths = [
        'uk-width-1-1 uk-width-1-5@m' => '20%',
        'uk-width-1-1 uk-width-1-4@m' => '25%', 
        'uk-width-1-1 uk-width-1-3@m' => '33.33%', 
        'uk-width-1-1 uk-width-1-2@m' => '50%',
        'uk-width-1-1' => 'Voll Breite',
        'uk-width-auto' => 'auto Breite'
    ];

    private static $block_text_offsets = [
        'no-offset' => 'Keine',
        'uk-position-small' => 'klein Offset', 
        'uk-position-medium' => 'medium Offset', 
        'uk-position-large' => 'gross Offset'
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

        

    private static $extensions = [
        'Activable',
        'Linkable',
        'Sortable'
    ];

    private static $effects = [
        'none' => 'kein',
        'kenburns' => 'ken burns',
        'parallax' => 'parallax'
    ];


    private static $owns = [
        'Image',
    ];

    private static $summary_fields = [
        'SlideTitle',
        'ImageThumbnail' 
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['SlideTitle'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['ImageThumbnail'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['Title'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['Content'] = _t(__CLASS__.'.ContentLabel','Inhalt');
        $labels['Image'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['CallToActionLink'] = _t(__CLASS__.'.CTA', 'Link');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('ParentID');
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
        $fields->addFieldToTab('Root.Main',CheckboxField::create('isMainSlide',_t(__CLASS__.'isMainSlide','Slide principale (contient le titre de la page)')));
        $fields->addFieldToTab('Root.Main',DropdownField::create('Effect',_t(__CLASS__.'.Effect','Effekt'), $this->getTranslatedSourceFor(__CLASS__,'effects')));
        $fields->addFieldToTab('Root.Main',TextField::create('EffectOptions',_t(__CLASS__.'.EffectOptions','Effekt Optionen')));
        $fields->FieldByName('Root.Main.Content')->setRows(3);
        $fields->FieldByName('Root.Main')->setTitle(_t(__CLASS__.'.ContentTab','Inhalt'));
        $fields->addFieldsToTab('Root.LayoutTab',[
             HTMLDropdownField::create('Background',_t(__CLASS__.'.BackgroundColor','Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->setDescription(_t(__CLASS__.'.BackgroundColorHelpText','wird als overlay anzeigen falls es ein Hintergrundbild gibt.'))->addExtraClass('colors'),
            HTMLDropdownField::create('TextBackground',_t(__CLASS__.'.BackgroundColor','Text Hintergrundfarbe'),SiteConfig::current_site_config()->getBackgroundColors())->addExtraClass('colors'),
            CheckboxField::create('TextOpacity',_t(__CLASS__.'.TextOpacity','Hintergrund leicht transparent ?')),
            HTMLOptionsetField::create('TextPosition',_t(__CLASS__.'.TextPosition','Text Position'),$this->stat('block_text_positions')),
            DropdownField::create('TextWidth',_t(__CLASS__.'.TextWidth','TextBreite'),$this->getTranslatedSourceFor(__CLASS__,'block_text_widths'))->setEmptyString(_t(__CLASS__.'.WidthLabel','Breite auswählen'))->setDescription(_t(__CLASS__.'.WidthDescription','Relative Breite im Vergleich zur Fußzeile')),
            DropdownField::create('TextOffset',_t(__CLASS__.'.TextOffset','Text Offset'),$this->getTranslatedSourceFor(__CLASS__,'block_text_offsets'))->setEmptyString(_t(__CLASS__.'.OffsetLabel','Offset hinzufügen')),
            HTMLOptionsetField::create('TitleAlign',_t(__CLASS__.'.TitleAlignment','Titelausrichtung'),$this->stat('block_text_alignments')),
            HTMLOptionsetField::create('TextAlign',_t(__CLASS__.'.TextAlignment','Textausrichtung'),$this->stat('block_text_alignments')),
            HTMLOptionsetField::create('TextColumns',_t(__CLASS__.'.TextColumns','Text in mehreren Spalten'),$this->stat('block_text_columns')),
            $columnDivider = CheckboxField::create('TextColumnsDivider',_t(__CLASS__.'.ShowColumnsBorder','Border zwischen Spalten anzeigen'))
            ]
        );

        $fields->FieldByName('Root.LayoutTab')->setTitle(_t(__CLASS__.'.LayoutTab','Layout'));

        if ($this->isMainSlide){
            $fields->removeByName('TitleAndDisplayed');
        }

        return $fields;
    }

    public function SlideTitle(){
        $o = new DBHTMLText();
        $o->setValue($this->Title);
        return $o;
    }

    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? (($this->Image()->getExtension() == "svg" ) ? '<img src="'.$this->Image()->URL.'" class="svg-slide-thumbnail" />' : '<img src="'.$this->Image()->Fill(400,200)->URL.'" />') : _t(__CLASS__.'.NoBild','(keine)');
        $o->setValue($html);
        return $o;
    }

    public function getFolderName(){
        return 'Uploads/slider';
    }



    public function ImageForTemplate(){

        $html = '<img ';
        $height = $this->Parent()->ImageHeight();
        $ratio = $this->Image()->getWidth() / $this->Image()->getHeight();
        $width = $ratio * $height;
        $html .= ' src="'.$this->Image()->FocusFillMax($width,$height)->Link().'" data-uk-cover />';

        return DBField::create_field('HTMLText',$html);
    }

    /************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('effects') as $key => $value) {
          $entities[__CLASS__.".effects_{$key}"] = $value;
        }
        foreach($this->stat('block_text_widths') as $key => $value) {
          $entities[__CLASS__.".block_text_widths_{$key}"] = $value;
        }
        foreach($this->stat('block_text_offsets') as $key => $value) {
          $entities[__CLASS__.".block_text_offsets_{$key}"] = $value;
        }
       
        return $entities;
    }

/************* END TRANLSATIONS *******************/

}
