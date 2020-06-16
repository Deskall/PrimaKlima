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
      $compatibility = 0;
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
        $compatibility += 40;
      }

      ob_start();
          print_r('compatibility: '.$compatibility."\n");
          $result = ob_get_clean();
          file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);

      //2. other 60%
        //Weight given by parameter in CMS
      foreach($this->Parameters()->exclude('Title','Position') as $qp){
        ob_start();
            print_r('param: '.$qp->Title."\n");
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
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
            break;
            case "multiple-free":
            break;
            case "range":
              $wanted = $qp->Value;
              if ($wanted >= $assigned->Value){
                $compatibility += $param->relativeWeight();
              }
              else{
                $compatibility += $param->relativeWeight() * ($assigned->Value / $wanted);
              }
            break;
          }
        }
        ob_start();
            print_r('wanted: '.$qp->Value."\n");
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
             ob_start();
            print_r('given: '.$assigned->Value."\n");
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
        ob_start();
            print_r('compatibility: '.$compatibility."\n");
            $result = ob_get_clean();
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result, FILE_APPEND);
      }




      ob_start();
          print_r('compatibility: '.$compatibility."\n");
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
