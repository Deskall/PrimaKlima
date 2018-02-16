<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class BoxBlock extends BaseElement
{
    private static $icon = 'font-icon-block-layout';

    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'BoxPerLine' => 'Varchar(255)',
        'ImageType' => 'Varchar(255)',
        'Effect' => 'Varchar(255)'
    ];

    private static $has_many = [
        'Boxes' => Box::class
    ];

    private static $owns = [
        'Boxes',
    ];

    private static $defaults = [
        'Layout' => 'standard',
        'Effect' => 'none'
    ];

    private static $block_layouts = [
        'standard' => 'Titel, Bild, Inhalt',
        'mixed' => 'Bild, Titel, Inhalt',
        'inversed' => 'Titel,Inhalt,Bild'
    ];

    private static $image_types = [
        'image' => 'Bild',
        'icon' => 'Icon'
    ];


    private static $effects = [
        'none' => 'kein',
        'double' => 'Zweiten Bild anzeigen',
        'scale' => 'Bild grossieren',
        'cta' => 'CallToAction anzeigen',
    ];

    private static $boxes_per_line = [
        'uk-child-width-1-2@s' => '2',
        'uk-child-width-1-3@s' => '3',
        'uk-child-width-1-3@s uk-child-width-1-4@m' => '4',
        'uk-child-width-1-3@s uk-child-width-1-5@m' => '5'
    ];


    private static $table_name = 'BoxBlock';

    private static $singular_name = 'Boxen Block';

    private static $plural_name = 'Boxen Blöcke';

    private static $description = 'mehrere Inhalt Boxen per Linie';

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
          
            $fields->removeByName('Boxes');
            $fields->addFieldToTab('Root.Settings',LayoutField::create('Layout','Format', self::$block_layouts));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('BoxPerLine','Boxen per Linie', self::$boxes_per_line));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('ImageType','BildTyp', self::$image_types));
            $fields->addFieldToTab('Root.Settings',DropdownField::create('Effect','Effect', self::$effects));

            if ($this->ID > 0){
                $config = GridFieldConfig_RecordEditor::create();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Box')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $boxesField = new GridField('Boxes','Boxes',$this->Boxes(),$config);
                $fields->addFieldToTab('Root.Boxen',$boxesField);
            }
        });
        $fields = parent::getCMSFields();

        return $fields;
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Boxen');
    }

    public function activeBoxes(){
        if (singleton('Box')->hasExtension('Activable')){
            return $this->Boxes()->filter('isVisible',1);
        }
        return $this->Boxes();
    }

}
