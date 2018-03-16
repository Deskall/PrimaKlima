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
use SilverStripe\Forms\Tab;

class BoxBlock extends BaseElement
{
    private static $icon = 'font-icon-block-layout';

    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'BoxPerLine' => 'Varchar(255)',
        'ImageType' => 'Varchar(255)',
        'Effect' => 'Varchar(255)',
        'BoxTextAlign' => 'Varchar(255)',
        'PictureWidth' => 'Int',
        'PictureHeight' => 'Int'
    ];

    private static $has_many = [
        'Boxes' => Box::class
    ];

    private static $owns = [
        'Boxes',
    ];

    private static $cascade_deletes = [
        'Boxes',
    ];

    private static $cascade_duplicates = ['Boxes'];

    private static $defaults = [
        'Layout' => 'standard',
        'Effect' => 'none',
        'BoxPerLine' => 'uk-child-width-1-3@s'
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
        'uk-child-width-1-2@s uk-child-width-1-4@m' => '4',
        'uk-child-width-1-2@s uk-child-width-1-5@m' => '5'
    ];
    // private static $boxes_per_line = array(
    // 'uk-child-width-1-2@s' => array(
    //     'Title' => 'Option 0',
    //     'Attributes' => array(
    //         'data-html' => 'font-icon-block-layout',
            
    //     )
    // ),
    // 'value2' => array(
    //     'Title' => 'Option 2',
    //     'Attributes' => array(
    //         'data-myattribute' => 'This is an attribute value',
    //         'data-myattribute2' => 'This is a second attribute value'
    //     )
    // ));

     private static $boxes_text_alignments = [
        'uk-text-justify uk-text-left@s' =>  'Aligns text to the left.',
        'uk-text-justify uk-text-righ@st' =>  'Aligns text to the right',
        'uk-text-justify uk-text-center@s' => 'Centers text horizontally',
        'uk-text-justify' => 'Justifies text'
    ];



    private static $table_name = 'BoxBlock';

    private static $singular_name = 'Boxen Block';

    private static $plural_name = 'Boxen Blöcke';

    private static $description = 'mehrere Inhalt Boxen per Linie';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
       
          
            $fields->removeByName('Boxes');
            $fields->addFieldToTab('Root.Layout',LayoutField::create('Layout',_t(__CLASS__.'.Format','Format'), $this->getTranslatedSourceFor(__CLASS__,'block_layouts')));
            $fields->removeByName('PictureHeight');
            $fields->removeByName('PictureWidth');
           
            
           

            if ($this->ID > 0){
                $fields->addFieldToTab('Root',new Tab('Boxes',_t('BOXBLOCK.BOXTAB','Boxen')),'Settings');
                $fields->addFieldToTab('Root.Boxes',DropdownField::create('BoxTextAlign',_t(__CLASS__.'.BoxTextAlignment','Boxen Textausrichtung'),$this->getTranslatedSourceFor(__CLASS__,'boxes_text_alignments')));
                //$fields->addFieldToTab('Root.Boxes',IconDropdownField::create('BoxPerLine','Boxen per Linie', self::$boxes_per_line));
                $fields->addFieldToTab('Root.Boxes',DropdownField::create('BoxPerLine',_t(__CLASS__.'.BoxPerLine','Boxen per Linie'), self::$boxes_per_line));
                $fields->addFieldToTab('Root.Boxes',DropdownField::create('ImageType',_t(__CLASS__.'.ImageType','BildTyp'), $this->getTranslatedSourceFor(__CLASS__,'image_types')));
                $fields->addFieldToTab('Root.Boxes',DropdownField::create('Effect',_t(__CLASS__.'.Effect','Effekt'), $this->getTranslatedSourceFor(__CLASS__,'effects')));
                $config = GridFieldConfig_RecordEditor::create();
                $config->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Box')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $boxesField = new GridField('Boxes',_t(__CLASS__.'.Boxes','Boxen'),$this->Boxes(),$config);
                $fields->addFieldToTab('Root.Boxes',$boxesField);
            }
       
        

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


    public function onBeforeWrite(){
        parent::onBeforeWrite();
        $widthF = 2500;
        $widthN = 1200;
        $ratio = 1.4; 
        $width = ($this->FullWidth) ? $widthF / static::$boxes_per_line[$this->BoxPerLine] : $widthN /  static::$boxes_per_line[$this->BoxPerLine];
        $height = $width / $ratio;

        $this->PictureWidth = $width;
        $this->PictureHeight = $height;
    }

/************* TRANLSATIONS *******************/
    public function provideI18nEntities(){
        $entities = [];
        foreach($this->stat('block_layouts') as $key => $value) {
          $entities[__CLASS__.".block_layouts_{$key}"] = $value;
        }
        foreach($this->stat('image_types') as $key => $value) {
          $entities[__CLASS__.".image_types_{$key}"] = $value;
        }
        foreach($this->stat('effects') as $key => $value) {
          $entities[__CLASS__.".effects_{$key}"] = $value;
        }
       
        foreach($this->stat('boxes_text_alignments') as $key => $value) {
          $entities[__CLASS__.".boxes_text_alignments_{$key}"] = $value;
        }
       
        return $entities;
    }
/************* END TRANLSATIONS *******************/
}
