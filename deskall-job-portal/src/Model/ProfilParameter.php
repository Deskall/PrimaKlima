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

class ProfilParameter extends JobParameter
{
    private static $db = [
      'isGroup' => 'Boolean(0)'
    ];

    private static $singular_name = "Profil Parameter";
    private static $plural_name = "Profil Parameter";

    private static $has_one = [
        'Config' => JobPortalConfig::class
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
      
       return $fields;
    }
}