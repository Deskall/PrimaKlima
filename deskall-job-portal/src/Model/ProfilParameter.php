<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;

use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;

class ProfilParameter extends JobParameter
{
    private static $db = [
      'isGroup' => 'Boolean(0)'
    ];

    private static $singular_name = "Profil Parameter";
    private static $plural_name = "Profil Parameter";

    private static $has_one = [
        'Parent' => ProfilParameter::class
    ];

    private static $has_many = [
        'Children' => ProfilParameter::class
    ];

  

    private static $cascade_deletes = [
      'Children'
    ];


    public function fieldLabels($includerelation = true){
	    $labels = parent::fieldLabels($includerelation);

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
       $fields->removeByName('ParentID');
       $fields->removeByName('Children');
       $fields->removeByName('Values');
      
       if ($this->ID > 0){
       	$fields->fieldByName('Root.Main.FieldType')->hideIf('isGroup')->isChecked()->end();
       	$fields->fieldByName('Root.Main.Required')->hideIf('isGroup')->isChecked()->end();
       	if ($this->isGroup){
       		$config = 
       		 GridFieldConfig_RecordEditor::create()
       		 ->addComponent(new GridFieldOrderableRows('Sort'))
       		 ->addComponent(new GridFieldShowHideAction());

       		 $parametersField = new GridField('Children',_t(__CLASS__.'.Children','Parameters'),$this->Children(),$config);
       		 $fields->addFieldToTab('Root.Main',$parametersField);
       	}
       	else{
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