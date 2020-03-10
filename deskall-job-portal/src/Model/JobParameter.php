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
      'Min' => 'Int',
      'Max' => 'Int'
      
    );

    private static $singular_name = "Parameter";
    private static $plural_name = "Parameter";

    private static $has_one = [
        'Config' => JobPortalConfig::class,
    ];

    private static $has_many = [
        'Values' => JobParameterValue::class
    ];

    private static $summary_fields = [
       'Title'
    ];

    private static $extensions = [
        'Sortable',
        'Activable'
    ];

    private static $cascade_deletes = [
      'Values'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Parameter');
    $labels['Values'] = _t(__CLASS__.'.Values','Werte');
    $labels['FieldType'] = _t(__CLASS__.'.FieldType','Feldtyp');
    $labels['Required'] = _t(__CLASS__.'.Required','Plichtfeld?');
    $labels['Min'] = _t(__CLASS__.'.Min','min. Wert');
    $labels['Max'] = _t(__CLASS__.'.Max','max. Wert');

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
       $fields->removeByName('FieldType');
       if ($this->ID > 0){
           $fields->removeByName('Parameters');
           $fields->addFieldToTab('Root.Main',DropdownField::create('FieldType',$this->fieldLabels()['FieldType'],['text' => 'Text', 'dropdown' => 'Dropdown', 'multiple' => 'Mehrere Werte', 'multiple-free' => 'Mehrere Werte (neue Werte erlaubt)','range' => 'Schieberegler']));
          $fields->fieldByName('Root.Main.Min')->displayIf('FieldType')->isEqualTo('range')->end();
          $fields->fieldByName('Root.Main.Max')->displayIf('FieldType')->isEqualTo('range')->end();
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