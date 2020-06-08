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
use SilverStripe\ORM\GroupedList;

class MatchingQuery extends DataObject
{
  private static $db = [
    'Compatibility' => 'Float' 
  ];

  private static $singular_name = "Matching Tool Anfrage";
  private static $plural_name = "Matching Tool Anfragen";

  private static $has_one = [
      'Owner' => JobGiver::class
  ];

  private static $has_many = [
      'Results' => MatchingResult::class
  ];

  private static $many_many = [
      'Parameters' => MatchingQueryParameter::class
  ];

  private static $cascade_deletes = [
    'Results'
  ];


  public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);

    $labels['Compatibility'] = _t(__CLASS__.'.Compatibility','% Kompatibilität');
    $labels['Owner'] = _t(__CLASS__.'.Owner','Kunde');
    $labels['Results'] = _t(__CLASS__.'.Results','Ergebnisse');
    $labels['Parameters'] = _t(__CLASS__.'.Parameters','Parameters');
  
    return $labels;
  }

  public function onBeforeWrite(){
    parent::onBeforeWrite();
  }

  public function onAfterWrite(){
    parent::onAfterWrite();
  }

  public function getCMSFields(){
    $fields = parent::getCMSFields();
    return $fields;
  }
}
