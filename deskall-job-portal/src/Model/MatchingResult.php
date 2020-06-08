<?php

use SilverStripe\ORM\DataObject;


class MatchingResult extends DataObject
{
  private static $db = [
    'Compatibility' => 'Float',
    'isVisible' => 'Boolean(0)'
  ];

  private static $singular_name = "Matching Tool Ergebniss";
  private static $plural_name = "Matching Tool Ergebnisse";

  private static $has_one = [
      'Query' => MatchingQuery::class,
      'Candidat' => Candidat::class
  ];


  public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);

    $labels['Compatibility'] = _t(__CLASS__.'.Compatibility','% Kompatibilität');
    $labels['isVisible'] = _t(__CLASS__.'.isVisible','sichtbare Kontaktangaben?');
    $labels['Candidat'] = _t(__CLASS__.'.Candidat','Kandidat');
    $labels['Query'] = _t(__CLASS__.'.Query','Suche');
  
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
