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
    'Results', 'Parameters'
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

  public function getMatches(){
    $this->estimateCompatibilities();
    return $this->Results();
  }

  //Algorythm
  public function estimateCompatibilities(){
    ob_start();
          print_r('start estimation - compatibility: '.$this->Compatibility."<br/>");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
    //1. Main profil data = 40%
    $positionID = $this->Parameters()->filter('Title','Position')->first()->Value;
    $position = JobParameterValue::get()->byId($positionID);
    ob_start();
        print_r('position gesucht: '.$position->Title."<br/>");
        $result = ob_get_clean();
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
    //2. other 60%
      //Weight given by parameter in CMS
    $candidats = Candidat::get();
    foreach ($candidats as $c) {
      ob_start();
          print_r('bewerber: '.$c->ID."<br/>");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
      $compatibility = 0;
      //1.has position
      $hasPosition = false;
      if ($c->CVItems()->exists()){
        foreach ($c->CVItems() as $job) {
          ob_start();
              print_r('position: '.$job->Position."<br/>");
              $result = ob_get_clean();
              file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
          if ($job->Position == $position->Title){
            $hasPosition = true;
            break;
          }
        }
      }
      if ($hasPosition){
        $compatibility += 40;
      }
      ob_start();
          print_r('compatibility: '.$compatibility."<br/>");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
      if ($compatibility >= $this->Compatibility){
        $result = new MatchingResult();
        $result->Compatibility = $compatibility;
        $result->CandidatID = $c->ID;
        $result->write();
        $this->Results()->add($result);
      }
      
    }
  }

}
