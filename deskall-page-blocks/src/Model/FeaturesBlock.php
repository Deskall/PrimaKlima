<?php

use SilverStripe\Forms\HTMLEditor\HtmlEditorField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\ORM\FieldType\DBField;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Tab;

class FeaturesBlock extends BaseElement
{
    private static $icon = 'font-icon-block-file-list';
    
    private static $controller_template = 'BlockHolder';

    private static $controller_class = BlockController::class;

    private static $db = [
        'HTML' => 'HTMLText',
        'IconItem' => 'Varchar(255)',
        'FeaturesTitle' => 'Varchar(255)'
    ];

    private static $has_one = [
        'ContentImage' => Image::class
    ];

    private static $has_many = [
        'Features' => Features::class
    ];

    private static $cascade_delete = [
        'Features',
    ];


    private static $owns = [
        'ContentImage',
    ];

    private static $defaults = [
        'Layout' => 'left'
    ];


   
    private static $table_name = 'FeaturesBlock';

    private static $singular_name = 'Features block';

    private static $plural_name = 'Features blocks';

    private static $description = 'Features List';



    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields
                ->fieldByName('Root.Main.HTML')
                ->setTitle(_t(__CLASS__ . '.ContentLabel', 'Content'));
            
            $fields->removeByName('Features');
      
            if ($this->ID > 0){

                $config = 
                GridFieldConfig::create()
                ->addComponent(new GridFieldButtonRow('before'))
                ->addComponent(new GridFieldToolbarHeader())
                ->addComponent(new GridFieldTitleHeader())
                ->addComponent(new GridFieldEditableColumns())
                ->addComponent(new GridFieldDeleteAction())
                ->addComponent(new GridFieldAddNewInlineButton())
                ->addComponent(new GridFieldOrderableRows('Sort'));
                if (singleton('Features')->hasExtension('Activable')){
                     $config->addComponent(new GridFieldShowHideAction());
                }
                $featuresField = new GridField('Features','Features',$this->Features(),$config);
                $fields->insertAfter(new Tab('Features','Features'),'Main');
                $title = $fields
                ->fieldByName('Root.Main.FeaturesTitle');
                $title->setTitle(_t(__CLASS__ . '.FeaturesTitle', 'List Titel'));
                $fields->addFieldToTab('Root.Features',$title);
                $fields->addFieldToTab('Root.Features',$featuresField);
                $fields->addFieldToTab('Root.Features',$fields->fieldByName('Root.Main.FeaturesTitle'),'Features');
            } 
        });
        return parent::getCMSFields();
    }

    public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Features List');
    }

    public function activeFeatures(){
         if (singleton('Features')->hasExtension('Activable')){
            return $this->Features()->filter('isVisible',1);
        }
        return $this->Features();
    }

}
