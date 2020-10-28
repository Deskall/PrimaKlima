<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\Tab;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\SiteConfig\SiteConfig;

class ListItem extends DataObject
{

    private static $db = [
        'Title' => 'Text',
        'Content' => 'HTMLText',
        'Layout' => 'Varchar(255)',
        'TitleAlign' => 'Varchar(255)',
        'TextAlign' => 'Varchar(255)',
        'TextColumns' => 'Varchar(255)',
        'TextColumnsDivider' => 'Boolean(0)'
    ];

    private static $has_one = [
        'Parent' => ListBlock::class,
        'Image' => Image::class,
        'FooterBlock' => FooterBlock::class
    ];

    private static $extensions = [
        Versioned::class,
        'Activable',
        'Linkable',
        'Sortable',
        'Collapsable'
    ];


    private static $owns = [
        'Image',
    ];

    private static $defaults = [
       'Layout' => 'left',
       'TextAlign' => 'uk-text-left',
       'TitleAlign' => 'uk-text-left',
       'TextColumns' => '1',
       'TextColumnsDivider' => 0
    ];

    private static $layouts = [
        'left' => [
            'value' => 'left',
            'title' => 'Links',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-left.svg'
        ],
        'right' => [
            'value' => 'right',
            'title' => 'Rechts',
            'icon' => '/_resources/deskall-page-blocks/images/icon-text-right.svg'
        ]
    ];

    private static $text_alignments = [
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

    private static $text_columns = [
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

    private static $summary_fields = [
        'ItemTitle' ,
        'ImageThumbnail' ,
        'getSummary'
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['ItemTitle'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['Title'] = _t(__CLASS__.'.TitleLabel','Titel');
        $labels['ImageThumbnail'] = _t(__CLASS__.'.Image', 'Bild');
        $labels['getSummary'] = _t(__CLASS__.'.Summary',  'Inhalt');
        $labels['Content'] = _t(__CLASS__.'.Summary',  'Inhalt');
        $labels['Layout'] = _t(__CLASS__.'.Layout',  'Format');

        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('ParentID');
        $fields->removeByName('FooterBlockID');
        $fields->removeByName('Layout');
        $fields->removeByName('TitleAlign');
        $fields->removeByName('TextAlign');
        $fields->removeByName('TextColumns');
        $fields->removeByName('TextColumnsDivider');
        $fields->dataFieldByName('Image')->setFolderName($this->getFolderName());
        $fields->FieldByName('Root.Main.Content')->setRows(5);
        $fields->addFieldToTab('Root',new Tab('LayoutTab',_t(__CLASS__.'.LAYOUTTAB','Layout')));

        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            HTMLOptionsetField::create('Layout',_t(__CLASS__.'.Layout','Layout'),$this->stat('layouts'))
        )->setTitle(_t(__CLASS__.'.GlobalLayout','Layout Optionen'))->setName('GlobalLayout'));
        $fields->addFieldToTab('Root.LayoutTab',CompositeField::create(
            HTMLOptionsetField::create('TitleAlign',_t(__CLASS__.'.TitleAlignment','Titelausrichtung'),$this->stat('text_alignments')),
            HTMLOptionsetField::create('TextAlign',_t(__CLASS__.'.TextAlignment','Textausrichtung'),$this->stat('text_alignments')),
            HTMLOptionsetField::create('TextColumns',_t(__CLASS__.'.TextColumns','Text in mehreren Spalten'),$this->stat('text_columns')),
            $columnDivider = CheckboxField::create('TextColumnsDivider',_t(__CLASS__.'.ShowColumnsBorder','Border zwischen Spalten anzeigen'))
        )->setTitle(_t(__CLASS__.'.TextLayout','Text Optionen'))->setName('TextLayout'));
        

        return $fields;
    }

    public function ItemTitle(){
        $o = new DBHTMLText();
        $o->setValue($this->Title);
        return $o;
    }

    public function ImageThumbnail(){
        $o = new DBHTMLText();
        $html = ($this->Image() && $this->Image()->exists()) ? (($this->Image()->getExtension() == "svg" ) ? '<img src="'.$this->Image()->URL.'" width="150" height="100" />' : '<img src="'.$this->Image()->ScaleWidth(150)->URL.'" />') : _t(__CLASS__.'.NoBild','(keine)');
        $o->setValue($html);
        return $o;
    }

    public function getFolderName(){
        if ($this->ParentID > 0){
            return $this->Parent()->getFolderName();
        }
        if ($this->FooterBlockID > 0){
            return SiteConfig::current_site_config()->getFolderName();
        }
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->Content)->Summary(20);
    }

    public function getPage(){
        return $this->Parent()->getPage();
    }


/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];

        return $entities;
    }

/************* END TRANLSATIONS *******************/

}
