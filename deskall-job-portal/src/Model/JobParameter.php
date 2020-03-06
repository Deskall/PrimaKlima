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
      'Title' => 'Varchar',
      'FieldType' => 'Varchar(255)',
      'Required' => 'Boolean(0)',
      'isGroup' => 'Boolean(0)',
    );

    private static $singular_name = "Parameter";
    private static $plural_name = "Parameter";

    private static $has_one = [
        'Config' => JobPortalConfig::class,
        'Parent' => JobParameter::class
    ];

    private static $has_many = [
        'Children' => JobParameter::class,
        'Values' => JobParameterValue::class
    ];

    private static $summary_fields = [
       'Title'
    ];

    private static $extensions = [
        'Sortable',
        'Activable'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Parameter');
    $labels['Values'] = _t(__CLASS__.'.Values','Werte');
    $labels['FieldType'] = _t(__CLASS__.'.FieldType','Feldtyp');
    $labels['Required'] = _t(__CLASS__.'.Required','Plichtfeld?');
    $labels['Parent'] = _t(__CLASS__.'.Parent','Haupt Parameter');
    $labels['Children'] = _t(__CLASS__.'.Children','Parameters');
    $labels['isGroup'] = _t(__CLASS__.'.isGroup','Grupp?');

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
       $fields->removeByName('ParentID');
       $fields->removeByName('FieldType');
       if ($this->ID > 0){
        $fields->removeByName('isGroup');
        if (!$this->isGroup){
           $fields->addFieldToTab('Root.Main',DropdownField::create('FieldType',$this->fieldLabels()['FieldType'],['text' => 'Text', 'dropdown' => 'Dropdown', 'multiple' => 'Mehrere Werte', 'multiple-free' => 'Mehrere Werte (neue Werte erlaubt)']));
          $config = 
           GridFieldConfig::create()
           ->addComponent(new GridFieldButtonRow('before'))
           ->addComponent(new GridFieldToolbarHeader())
           ->addComponent(new GridFieldTitleHeader())
           ->addComponent(new GridFieldEditableColumns())
           ->addComponent(new GridFieldDeleteAction())
           ->addComponent(new GridFieldAddNewInlineButton())
           ->addComponent(new GridFieldOrderableRows('Sort'));
           if (singleton('JobParameterValue')->hasExtension('Activable')){
                $config->addComponent(new GridFieldShowHideAction());
           }

           $valuesField = new GridField('Values',_t(__CLASS__.'.Values','Werte'),$this->Values(),$config);
           $fields->addFieldToTab('Root.Main',$valuesField);
        }
       }
       return $fields;
    }
}