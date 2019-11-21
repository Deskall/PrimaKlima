<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;

use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;

class JobParameter extends DataObject
{
    private static $db = array(
      'Title' => 'Varchar'
    );

    private static $singular_name = "Parameter";
    private static $plural_name = "Parameter";

    private static $has_one = [
        'Config' => JobPortalConfig::class
    ];

    private static $has_many = [
        'Values' => JobParameterValue::class
    ];

    private static $summary_fields = [
       'Title'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Parameter');
    $labels['Values'] = _t(__CLASS__.'.Values','Werte');

    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('ConfigID');
       $fields->removeByName('Values');

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

       $featuresField = new GridField('Features',_t(__CLASS__.'.Features','Features'),$this->Features(),$config);
       $featuresField->addExtraClass('fluent__localised-field');
       $title = $fields->fieldByName('Root.Main.FeaturesTitle');
       $title->setTitle(_t(__CLASS__ . '.FeaturesTitle', 'Features List Titel'));
       $fields->addFieldToTab('Root.Main',$title);
       $fields->addFieldToTab('Root.Main',$featuresField);

       return $fields;
    }
}