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
          print_r('start estimation - compatibility: '.$this->Compatibility."\n");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
    //1. Main profil data = 40%
    $positionID = $this->Parameters()->filter('Title','Position')->first()->Value;
    $position = JobParameterValue::get()->byId($positionID);
    $candidats = Candidat::get();
    foreach ($candidats as $c) {
      ob_start();
          print_r('start bewerber: '.$c->ID."\n");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
      $mainCompatibility = 0;
      //1.has position
      $hasPosition = false;
      if ($c->CVItems()->exists()){
        foreach ($c->CVItems() as $job) {
          if ($job->Position == $position->Title){
            $hasPosition = true;
            break;
          }
        }
      }
      if ($hasPosition){
        $mainCompatibility += 40;
      }

      $compatibility = 0;

      //2. other 60%
        //Weight given by parameter in CMS
      foreach($this->Parameters()->exclude('Title','Position') as $qp){
        $param = $qp->Parameter();
        $weight = $param->Weight;
        $assigned = $c->Parameters()->filter('Title',$qp->Title)->first();
        if ($assigned) {
          switch($param->FieldType){
            case "text":
            case "dropdown":
              if ($qp->Value == $assigned->Value){
                $compatibility += $param->relativeWeight();
              }
            break;
            case "multiple":
            case "multiple-free":
            $wantedArray = explode(',',$qp->Value);
            $assignedArray = explode(';-;',$assigned->Value);
            $in = 0;
            foreach($wantedArray as $wanted){
              if (in_array($wanted,$assignedArray)){
                $in++;
              }
            }
            $compatibility += $param->relativeWeight() * $in / count($wantedArray);
            break;
            case "range":
              $wanted = $qp->Value;
              if ($assigned->Value >= $wanted ){
                $compatibility += $param->relativeWeight();
              }
              else{
                $compatibility += $param->relativeWeight() * ($assigned->Value / $wanted);
              }
            break;
          }
        }
      }




      ob_start();
          print_r('compatibility: '.$compatibility."\n");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);

      $secondCompatibility = 60 * $compatibility;
      ob_start();
          print_r('second compatibility: '.$secondCompatibility."\n");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
          ob_start();
              print_r('main compatibility: '.$mainCompatibility."\n");
              $result = ob_get_clean();
              file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
      $total = $mainCompatibility + $secondCompatibility;
      if ($total >= $this->Compatibility){
        $result = new MatchingResult();
        $result->Compatibility = $total;
        $result->CandidatID = $c->ID;
        $result->write();
        $this->Results()->add($result);
      }
      
    }
  }

}